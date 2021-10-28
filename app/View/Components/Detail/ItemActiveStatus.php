<?php

namespace App\View\Components\Detail;

use Illuminate\View\Component;

class ItemActiveStatus extends Component
{
    public $label;

    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'Status', $value)
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
        return view('components.detail.item-active-status');
    }
}
