<?php

namespace App\View\Components\FormContent;

use Illuminate\View\Component;

class SelectMultiple extends Component
{
    public $id;

    public $label;

    public $name;

    public $value;

    public $options;

    public $type;

    public $search;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $label, $name, $value = [], $options = [], $type = 'text', $search = true)
    {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
        $this->type = $type;
        $this->search = $search;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-content.select-multiple');
    }
}
