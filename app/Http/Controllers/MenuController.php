<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Check if user has super role to access this page
        $currentRoleId = session('current_role_id');
        $currentRole = Role::find($currentRoleId);
        
        if (!$currentRole || $currentRole->role_name !== 'super') {
            abort(403, 'Access denied. Only Super Administrator can access menu management.');
        }

        $menuItems = MenuItem::with('parent', 'children', 'roles')
            ->orderBy('order')
            ->get();

        $roles = Role::all();

        return view('admin.menu.index', compact('menuItems', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Check super role access
        $this->checkSuperAccess();

        $parentMenus = MenuItem::where('is_parent', true)
            ->orWhere('parent_id', null)
            ->orderBy('order')
            ->get();

        $roles = Role::all();

        return view('admin.menu.create', compact('parentMenus', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Check super role access
        $this->checkSuperAccess();

        $validated = $request->validate([
            'menu_name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'is_parent' => 'boolean',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        // Set is_parent to false if parent_id is provided
        if ($validated['parent_id']) {
            $validated['is_parent'] = false;
        }

        $menuItem = MenuItem::create($validated);

        // Attach roles if provided
        if (isset($validated['roles'])) {
            $menuItem->roles()->attach($validated['roles']);
        }

        // Clear menu cache
        MenuItem::clearAllMenuCache();

        return redirect()->route('menu.index')
            ->with('success', 'Menu item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuItem $menu): View
    {
        // Check super role access
        $this->checkSuperAccess();

        $menu->load('parent', 'children', 'roles');
        return view('admin.menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menu): View
    {
        // Check super role access
        $this->checkSuperAccess();

        $parentMenus = MenuItem::where('is_parent', true)
            ->where('id', '!=', $menu->id)
            ->orWhere('parent_id', null)
            ->where('id', '!=', $menu->id)
            ->orderBy('order')
            ->get();

        $roles = Role::all();
        $menu->load('roles');

        return view('admin.menu.edit', compact('menu', 'parentMenus', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menu): RedirectResponse
    {
        // Check super role access
        $this->checkSuperAccess();

        $validated = $request->validate([
            'menu_name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'is_parent' => 'boolean',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        // Set is_parent to false if parent_id is provided
        if ($validated['parent_id']) {
            $validated['is_parent'] = false;
        }

        $menu->update($validated);

        // Sync roles
        $menu->roles()->sync($validated['roles'] ?? []);

        // Clear menu cache
        MenuItem::clearAllMenuCache();

        return redirect()->route('menu.index')
            ->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menu): RedirectResponse
    {
        // Check super role access
        $this->checkSuperAccess();

        // Check if menu has children
        if ($menu->children()->count() > 0) {
            return redirect()->route('menu.index')
                ->with('error', 'Cannot delete menu item that has child items.');
        }

        // Detach roles before deleting
        $menu->roles()->detach();
        $menu->delete();

        // Clear menu cache
        MenuItem::clearAllMenuCache();

        return redirect()->route('menu.index')
            ->with('success', 'Menu item deleted successfully.');
    }

    /**
     * Toggle menu status
     */
    public function toggleStatus(MenuItem $menu): RedirectResponse
    {
        // Check super role access
        $this->checkSuperAccess();

        $menu->update(['is_active' => !$menu->is_active]);

        return redirect()->route('menu.index')
            ->with('success', 'Menu status updated successfully.');
    }

    /**
     * Update menu order
     */
    public function updateOrder(Request $request): RedirectResponse
    {
        // Check super role access
        $this->checkSuperAccess();

        $validated = $request->validate([
            'menu_orders' => 'required|array',
            'menu_orders.*.id' => 'required|exists:menu_items,id',
            'menu_orders.*.order' => 'required|integer|min:0'
        ]);

        foreach ($validated['menu_orders'] as $menuOrder) {
            MenuItem::where('id', $menuOrder['id'])
                ->update(['order' => $menuOrder['order']]);
        }

        return redirect()->route('menu.index')
            ->with('success', 'Menu order updated successfully.');
    }

    /**
     * Check if current user has super role access
     */
    private function checkSuperAccess(): void
    {
        $currentRoleId = session('current_role_id');
        $currentRole = Role::find($currentRoleId);
        
        if (!$currentRole || $currentRole->role_name !== 'super') {
            abort(403, 'Access denied. Only Super Administrator can access menu management.');
        }
    }

    /**
     * Manage menu roles assignment
     */
    public function manageRoles(MenuItem $menu): View
    {
        // Check super role access
        $this->checkSuperAccess();

        $menu->load('roles');
        $roles = Role::all();

        return view('admin.menu.manage-roles', compact('menu', 'roles'));
    }

    /**
     * Update menu roles assignment
     */
    public function updateRoles(Request $request, MenuItem $menu): RedirectResponse
    {
        // Check super role access
        $this->checkSuperAccess();

        $validated = $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        $menu->roles()->sync($validated['roles'] ?? []);

        // Clear menu cache
        MenuItem::clearAllMenuCache();

        return redirect()->route('menu.index')
            ->with('success', 'Menu roles updated successfully.');
    }
}