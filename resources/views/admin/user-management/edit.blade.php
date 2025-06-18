<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold mb-5">Edit User: {{ $employee->name ?? $user->email }}</h1>
            <form action="{{ route('admin.user-management.update', $user->id) }}" method="POST" class="ajax-form space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $employee->name ?? '') }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                           required placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                           required placeholder="contoh@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="role_id" class="block mb-2 text-sm font-medium">Role</label>
                    <select id="role_id" name="role_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" 
                                {{ (old('role_id', $currentRole->id ?? '')) == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name ?? $role->role_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="outlet_id" class="block mb-2 text-sm font-medium">Outlet</label>
                    <select id="outlet_id" name="outlet_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}" 
                                {{ (old('outlet_id', $employee->outlet_id ?? '')) == $outlet->id ? 'selected' : '' }}>
                                {{ $outlet->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('outlet_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="position" class="block mb-2 text-sm font-medium">Posisi/Jabatan (Opsional)</label>
                    <input type="text" id="position" name="position" value="{{ old('position', $employee->position ?? '') }}" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                           placeholder="Contoh: Manager, Kasir, Staff">
                    @error('position')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium">Password Baru (Opsional)</label>
                    <input type="password" id="password" name="password" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                           placeholder="Kosongkan jika tidak ingin mengubah password">
                    <p class="mt-1 text-sm text-gray-500">Minimal 4 karakter. Kosongkan jika tidak ingin mengubah password.</p>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-400">
                                Peringatan
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                <p>Mengubah role user akan memengaruhi akses mereka ke sistem.</p>
                                <p>User yang sedang login mungkin perlu login ulang untuk melihat perubahan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-400">
                                Informasi
                            </h3>
                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                <p>Nama: <strong>{{ $employee->name ?? 'Tidak diketahui' }}</strong></p>
                                <p>Email: <strong>{{ $user->email }}</strong></p>
                                <p>Outlet: <strong>{{ $employee->outlet->name ?? 'Tidak diketahui' }}</strong></p>
                                <p>Posisi: <strong>{{ $employee->position ?? 'Tidak ditentukan' }}</strong></p>
                                <p>User ini terdaftar di lembaga: <strong>{{ $lembaga->name ?? 'Tidak diketahui' }}</strong></p>
                                <p>Role saat ini: <strong>{{ $currentRole->display_name ?? $currentRole->role_name ?? 'Tidak ada role' }}</strong></p>
                                <p>Bergabung: <strong>{{ $employee->joined_at ? $employee->joined_at->format('d-m-Y') : 'Tidak diketahui' }}</strong></p>
                                <p>Akun dibuat: <strong>{{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : 'Tidak diketahui' }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('admin.user-management.index') }}" 
                       class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-6 py-3">
                        Batal
                    </a>
                    <button type="button" onclick="resetPassword({{ $user->id }})" 
                            class="text-white bg-yellow-600 hover:bg-yellow-700 font-medium rounded-lg text-sm px-6 py-3">
                        <i class="fas fa-key mr-2"></i>Reset Password
                    </button>
                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-6 py-3">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>