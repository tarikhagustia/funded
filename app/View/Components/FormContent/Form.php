<?php

namespace App\View\Components\FormContent;

use Illuminate\View\Component;

class Form extends Component
{
    public $title;

    public $action;

    public $method;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $action, $method = 'POST')
    {
        $this->title = $title;
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
        return view('components.form-content.form');
    }
}
