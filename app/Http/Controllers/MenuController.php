<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
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
        $menuItems = MenuItem::with('parent', 'children')
            ->orderBy('order')
            ->get();

        return view('admin.menu.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $parentMenus = MenuItem::where('is_parent', true)
            ->orWhere('parent_id', null)
            ->orderBy('order')
            ->get();

        return view('admin.menu.create', compact('parentMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'menu_name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'is_parent' => 'boolean',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Set is_parent to false if parent_id is provided
        if ($validated['parent_id']) {
            $validated['is_parent'] = false;
        }

        MenuItem::create($validated);

        return redirect()->route('menu.index')
            ->with('success', 'Menu item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuItem $menu): View
    {
        $menu->load('parent', 'children');
        return view('admin.menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menu): View
    {
        $parentMenus = MenuItem::where('is_parent', true)
            ->where('id', '!=', $menu->id)
            ->orWhere('parent_id', null)
            ->where('id', '!=', $menu->id)
            ->orderBy('order')
            ->get();

        return view('admin.menu.edit', compact('menu', 'parentMenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menu): RedirectResponse
    {
        $validated = $request->validate([
            'menu_name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'is_parent' => 'boolean',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Set is_parent to false if parent_id is provided
        if ($validated['parent_id']) {
            $validated['is_parent'] = false;
        }

        $menu->update($validated);

        return redirect()->route('menu.index')
            ->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menu): RedirectResponse
    {
        // Check if menu has children
        if ($menu->children()->count() > 0) {
            return redirect()->route('menu.index')
                ->with('error', 'Cannot delete menu item that has child items.');
        }

        $menu->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Menu item deleted successfully.');
    }

    /**
     * Toggle menu status
     */
    public function toggleStatus(MenuItem $menu): RedirectResponse
    {
        $menu->update(['is_active' => !$menu->is_active]);

        return redirect()->route('menu.index')
            ->with('success', 'Menu status updated successfully.');
    }

    /**
     * Update menu order
     */
    public function updateOrder(Request $request): RedirectResponse
    {
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
}