<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminLayout extends Component
{
    /**
     * Create a new component instance.
     */

    public $user;
    public $lembaga;

    public function __construct()
    {
        //
        $this->user = auth()->user();
        $this->lembaga = $this->user ? $this->user->getCurrentLembaga() : null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.admin');
    }
}
