<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Number extends Component
{
    public $id;

    public $label;

    public $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $label, $name)
    {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.number');
    }
}
