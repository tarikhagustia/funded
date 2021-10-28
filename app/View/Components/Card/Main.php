<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class Main extends Component
{
    public $title;

    public $footer;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $footer = null)
    {
        $this->title = $title;
        $this->footer = $footer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card.main');
    }
}
