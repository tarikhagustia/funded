<?php

namespace App\View\Components\FormContent;

use Illuminate\View\Component;

class FileMultiple extends Component
{
    public $id;

    public $label;

    public $name;

    public $values;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $label, $name, array $values = [])
    {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->values = $values;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-content.file-multiple');
    }
}
