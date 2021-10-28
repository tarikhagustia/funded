<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Upload extends Component
{
    public $action;

    public $method;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action, $method = 'POST')
    {
        $this->action = $action;
        $this->method = $method;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.upload');
    }
}
