<?php

namespace App\View\Components\city_admin;

use Illuminate\View\Component;

class city_adminsidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.city_admin.city_adminsidebar');
    }
}
