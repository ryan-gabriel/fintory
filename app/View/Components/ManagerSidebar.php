<?php

namespace App\View\Components;

use App\Models\MenuItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ManagerSidebar extends Component
{
    public $menuItems;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->menuItems = MenuItem::getMenuHierarchy();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.manager-sidebar', [
            'menuItems' => $this->menuItems
        ]);
    }
}