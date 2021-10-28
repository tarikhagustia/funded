<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class File extends Component
{
    public $id;

    public $label;

    public $name;

    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $label = null, $name, $value = null)
    {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.file');
    }
}
