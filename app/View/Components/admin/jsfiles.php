<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class jsfiles extends Component
{
     public $class_name = "";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classname)
    {
        //
        $this->class_name = $classname;
     }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.jsfiles');
    }
}
