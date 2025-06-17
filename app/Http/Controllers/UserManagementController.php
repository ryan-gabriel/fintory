<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Lembaga;
use App\Models\Employee;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');
        $lembaga = Lembaga::find($currentLembagaId);
        
        $viewData = compact('lembaga');

        if ($request->ajax()) {
            return view('admin.user-management.index', $viewData);
        }

        return view('layouts.admin', [
            'slot' => view('admin.user-management.index', $viewData),
            'title' => 'Manajemen User & Role',
            'lembaga' => $lembaga,
        ]);
    }

    public function getData(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');
        
        // Debug: Log current lembaga ID
        Log::info('Current Lembaga ID: ' . $currentLembagaId);
        
        // Debug: Check if there are any users with employees in this lembaga
        $userCount = User::whereHas('employees', function ($q) use ($currentLembagaId) {
            $q->where('lembaga_id', $currentLembagaId);
        })->count();
        Log::info('Users with employees in lembaga ' . $currentLembagaId . ': ' . $userCount);
        
        // Debug: Check all employees in this lembaga
        $employeeCount = \App\Models\Employee::where('lembaga_id', $currentLembagaId)->count();
        Log::info('Total employees in lembaga ' . $currentLembagaId . ': ' . $employeeCount);
        
        // Query users yang terhubung dengan lembaga current melalui employee
        $query = User::whereHas('employees', function ($q) use ($currentLembagaId) {
            $q->where('lembaga_id', $currentLembagaId);
        })->with(['employees' => function ($q) use ($currentLembagaId) {
            $q->where('lembaga_id', $currentLembagaId);
        }, 'lembagaRoles' => function ($q) use ($currentLembagaId) {
            $q->wherePivot('lembaga_id', $currentLembagaId);
        }]);

        // Filter tanggal dibuat
        if ($request->filled('start_date')) {
            try {
                $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            } catch (\Exception $e) {
                // Log error if needed
            }
        }

        if ($request->filled('end_date')) {
            try {
                $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay();
                $query->where('created_at', '<=', $endDate);
            } catch (\Exception $e) {
                // Log error if needed
            }
        }

        // Total data sebelum filter
        $totalData = User::whereHas('employees', function ($q) use ($currentLembagaId) {
            $q->where('lembaga_id', $currentLembagaId);
        })->count();

        // Global search
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search, $currentLembagaId) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y') like ?", ["%{$search}%"])
                  ->orWhereHas('employees', function ($empQuery) use ($search, $currentLembagaId) {
                      $empQuery->where('lembaga_id', $currentLembagaId)
                               ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Total data setelah filter
        $totalFiltered = $query->count();

        // Debug: Log totals
        Log::info('Total data: ' . $totalData . ', Total filtered: ' . $totalFiltered);

        // Ordering
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        $orderableColumns = [
            0 => 'email', // We'll handle name ordering separately
            1 => 'email',
            2 => 'created_at'
        ];

        if (isset($orderableColumns[$orderColIndex])) {
            $query->orderBy($orderableColumns[$orderColIndex], $orderDir);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $start = max(0, intval($request->input('start', 0)));
        $length = max(1, intval($request->input('length', 10)));

        $data = $query->skip($start)->take($length)->get();
        
        // Debug: Log retrieved data
        Log::info('Retrieved users count: ' . $data->count());
        foreach ($data as $user) {
            Log::info('User: ' . $user->email . ' - Employee: ' . ($user->employees->first()->name ?? 'No employee'));
        }

        $jsonData = [
            "draw" => intval($request->input('draw', 1)),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => [],
        ];

        foreach ($data as $user) {
            $employee = $user->employees->first();
            $employeeName = $employee ? $employee->name : '-';
            
            $role = $user->lembagaRoles->first();
            $roleName = $role ? $role->display_name : '-';
            
            $actions = '
                <div class="flex space-x-2">
                    <a href="' . route('admin.user-management.edit', $user->id) . '" 
                       class="edit-link text-blue-600 hover:text-blue-800" 
                       data-title="Edit User">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="resetPassword(' . $user->id . ')" 
                            class="text-yellow-600 hover:text-yellow-800" 
                            title="Reset Password">
                        <i class="fas fa-key"></i>
                    </button>
                    <button onclick="deleteUser(' . $user->id . ')" 
                            class="text-red-600 hover:text-red-800" 
                            title="Hapus User">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>';

            $jsonData['data'][] = [
                $employeeName,
                $user->email,
                $roleName,
                $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-',
                $actions
            ];
        }

        return response()->json($jsonData);
    }

    public function create(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');
        $roles = Role::all();
        $outlets = Outlet::where('lembaga_id', $currentLembagaId)->get();
        $lembaga = Lembaga::find($currentLembagaId);

        $viewData = compact('roles', 'outlets', 'lembaga');

        if ($request->ajax()) {
            return view('admin.user-management.create', $viewData);
        }

        return view('layouts.admin', [
            'slot' => view('admin.user-management.create', $viewData),
            'title' => 'Tambah User Baru',
            'lembaga' => $lembaga,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4'],
            'role_id' => ['required', 'exists:roles,id'],
            'outlet_id' => ['required', 'exists:outlet,id'],
            'position' => ['nullable', 'string', 'max:100'],
        ]);

        $currentLembagaId = session('current_lembaga_id');

        // Verify outlet belongs to current lembaga
        $outlet = Outlet::where('id', $request->outlet_id)
                       ->where('lembaga_id', $currentLembagaId)
                       ->first();
        
        if (!$outlet) {
            return back()->withErrors(['outlet_id' => 'Outlet tidak valid untuk lembaga ini.']);
        }

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Create employee record
            Employee::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'outlet_id' => $request->outlet_id,
                'lembaga_id' => $currentLembagaId,
                'position' => $request->position,
                'joined_at' => today(),
            ]);

            // Attach user to lembaga with role
            $user->lembagaRoles()->attach($request->role_id, [
                'lembaga_id' => $currentLembagaId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil ditambahkan!'
                ]);
            }

            return redirect()->route('admin.user-management.index')
                           ->with('success', 'User berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                        ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function edit(Request $request, $id)
    {
        $currentLembagaId = session('current_lembaga_id');
        
        $user = User::whereHas('employees', function ($q) use ($currentLembagaId) {
            $q->where('lembaga_id', $currentLembagaId);
        })->findOrFail($id);

        $employee = $user->getEmployeeInLembaga($currentLembagaId);
        $roles = Role::all();
        $outlets = Outlet::where('lembaga_id', $currentLembagaId)->get();
        $currentRole = $user->lembagaRoles()
                           ->wherePivot('lembaga_id', $currentLembagaId)
                           ->first();
        
        $lembaga = Lembaga::find($currentLembagaId);

        $viewData = compact('user', 'employee', 'roles', 'outlets', 'currentRole', 'lembaga');

        if ($request->ajax()) {
            return view('admin.user-management.edit', $viewData);
        }

        return view('layouts.admin', [
            'slot' => view('admin.user-management.edit', $viewData),
            'title' => 'Edit User',
            'lembaga' => $lembaga,
        ]);
    }

    public function update(Request $request, $id)
    {
        $currentLembagaId = session('current_lembaga_id');
        
        $user = User::whereHas('employees', function ($q) use ($currentLembagaId) {
            $q->where('lembaga_id', $currentLembagaId);
        })->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
            'outlet_id' => ['required', 'exists:outlet,id'],
            'position' => ['nullable', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:4'],
        ]);

        // Verify outlet belongs to current lembaga
        $outlet = Outlet::where('id', $request->outlet_id)
                       ->where('lembaga_id', $currentLembagaId)
                       ->first();
        
        if (!$outlet) {
            return back()->withErrors(['outlet_id' => 'Outlet tidak valid untuk lembaga ini.']);
        }

        try {
            DB::beginTransaction();

            // Update user data
            $userData = ['email' => $request->email];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            // Update employee data
            $employee = $user->getEmployeeInLembaga($currentLembagaId);
            if ($employee) {
                $employee->update([
                    'name' => $request->name,
                    'outlet_id' => $request->outlet_id,
                    'position' => $request->position,
                ]);
            } else {
                // Create employee if doesn't exist
                Employee::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'outlet_id' => $request->outlet_id,
                    'lembaga_id' => $currentLembagaId,
                    'position' => $request->position,
                    'joined_at' => today(),
                ]);
            }

            // Update role in pivot table
            $user->lembagaRoles()->wherePivot('lembaga_id', $currentLembagaId)->detach();
            $user->lembagaRoles()->attach($request->role_id, [
                'lembaga_id' => $currentLembagaId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil diupdate!'
                ]);
            }

            return redirect()->route('admin.user-management.index')
                           ->with('success', 'User berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollback();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                        ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $currentLembagaId = session('current_lembaga_id');
        
        $user = User::whereHas('employees', function ($q) use ($currentLembagaId) {
            $q->where('lembaga_id', $currentLembagaId);
        })->findOrFail($id);

        try {
            DB::beginTransaction();

            // Remove employee from current lembaga
            $employee = $user->getEmployeeInLembaga($currentLembagaId);
            if ($employee) {
                $employee->delete();
            }

            // Remove user from current lembaga
            $user->lembagaRoles()->wherePivot('lembaga_id', $currentLembagaId)->detach();

            // If user has no other lembaga associations, delete the user
            if (!$user->lembagaRoles()->exists() && !$user->employees()->exists()) {
                $user->delete();
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.user-management.index')
                           ->with('success', 'User berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollback();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function resetPassword(Request $request, $id)
    {
        $currentLembagaId = session('current_lembaga_id');
        
        $user = User::whereHas('employees', function ($q) use ($currentLembagaId) {
            $q->where('lembaga_id', $currentLembagaId);
        })->findOrFail($id);

        try {
            $user->update([
                'password' => Hash::make('12345')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil direset ke 12345!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function debug(Request $request)
    {
        $currentLembagaId = session('current_lembaga_id');
        
        $debug = [
            'current_lembaga_id' => $currentLembagaId,
            'session_data' => session()->all(),
            'users_count' => \App\Models\User::count(),
            'employees_count' => \App\Models\Employee::count(),
            'lembaga_user_role_count' => DB::table('lembaga_user_role')->count(),
        ];
        
        // Check users in current lembaga
        $usersInLembaga = \App\Models\User::whereHas('employees', function ($q) use ($currentLembagaId) {
            $q->where('lembaga_id', $currentLembagaId);
        })->with(['employees', 'lembagaRoles'])->get();
        
        $debug['users_in_current_lembaga'] = $usersInLembaga->map(function ($user) {
            return [
                'id' => $user->id,
                'email' => $user->email,
                'employees' => $user->employees->map(function ($emp) {
                    return [
                        'id' => $emp->id,
                        'name' => $emp->name,
                        'lembaga_id' => $emp->lembaga_id,
                        'outlet_id' => $emp->outlet_id,
                    ];
                }),
                'roles' => $user->lembagaRoles->map(function ($role) {
                    return [
                        'id' => $role->id,
                        'role_name' => $role->role_name,
                        'lembaga_id' => $role->pivot->lembaga_id,
                    ];
                }),
            ];
        });
        
        // Check all employees in current lembaga
        $employees = \App\Models\Employee::where('lembaga_id', $currentLembagaId)->with(['user', 'outlet'])->get();
        $debug['employees_in_current_lembaga'] = $employees->map(function ($emp) {
            return [
                'id' => $emp->id,
                'name' => $emp->name,
                'user_email' => $emp->user->email ?? 'No user',
                'outlet_name' => $emp->outlet->name ?? 'No outlet',
                'lembaga_id' => $emp->lembaga_id,
            ];
        });
        
        
        return response()->json($debug);
    }

    // public function getDataSimple(Request $request)
    // {
    //     $currentLembagaId = session('current_lembaga_id');
        
    //     // Query sederhana - ambil semua employee di lembaga ini dengan user
    //     $employees = \App\Models\Employee::where('lembaga_id', $currentLembagaId)
    //                                     ->with(['user', 'outlet'])
    //                                     ->get();
        
    //     $jsonData = [
    //         "draw" => intval($request->input('draw', 1)),
    //         "recordsTotal" => $employees->count(),
    //         "recordsFiltered" => $employees->count(),
    //         "data" => [],
    //     ];

    //     foreach ($employees as $employee) {
    //         $user = $employee->user;
    //         if (!$user) continue;
            
    //         // Get role for this user in current lembaga
    //         $role = $user->lembagaRoles()
    //                      ->wherePivot('lembaga_id', $currentLembagaId)
    //                      ->first();
            
    //         $roleName = $role ? $role->display_name : '-';
            
    //         $actions = '
    //             <div class="flex space-x-2">
    //                 <a href="' . route('admin.user-management.edit', $user->id) . '" 
    //                    class="edit-link text-blue-600 hover:text-blue-800" 
    //                    data-title="Edit User">
    //                     <i class="fas fa-edit"></i>
    //                 </a>
    //                 <button onclick="resetPassword(' . $user->id . ')" 
    //                         class="text-yellow-600 hover:text-yellow-800" 
    //                         title="Reset Password">
    //                     <i class="fas fa-key"></i>
    //                 </button>
    //                 <button onclick="deleteUser(' . $user->id . ')" 
    //                         class="text-red-600 hover:text-red-800" 
    //                         title="Hapus User">
    //                     <i class="fas fa-trash"></i>
    //                 </button>
    //             </div>';

    //         $jsonData['data'][] = [
    //             $employee->name,
    //             $user->email,
    //             $roleName,
    //             $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-',
    //             $actions
    //         ];
    //     }

    //     return response()->json($jsonData);
    // }
}