<?php

namespace App\View\Components;

use App\Models\MenuItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ManagerSidebar extends Component
{
    public $menuItems;
    public $user;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Use cached menu hierarchy
        $this->menuItems = MenuItem::getMenuHierarchy();
        $this->user = auth()->user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.manager-sidebar', [
            'menuItems' => $this->menuItems,
            'user' => $this->user,
        ]);
    }
}