<?php

namespace App\View\Components\Data;

use Illuminate\View\Component;

class ShowItem extends Component
{
    public $label;

    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.data.show-item');
    }
}
