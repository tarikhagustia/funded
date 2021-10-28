<?php

namespace App\View\Components\FormContent;

use Illuminate\View\Component;

class Select extends Component
{
    public $id;

    public $label;

    public $name;

    public $value;

    public $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $label, $name, $value = null, $options = [])
    {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-content.select');
    }
}
