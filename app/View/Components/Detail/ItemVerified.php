<?php

namespace App\View\Components\Detail;

use Illuminate\View\Component;

class ItemVerified extends Component
{
    public $label;

    public $value;

    public $verified;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $value, $verified = false)
    {
        $this->label = $label;
        $this->value = $value;
        $this->verified = $verified;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.detail.item-verified');
    }
}
