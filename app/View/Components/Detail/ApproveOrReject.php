<?php

namespace App\View\Components\Detail;

use Illuminate\View\Component;

class ApproveOrReject extends Component
{
    public $approve;

    public $reject;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($approve, $reject)
    {
        $this->approve = $approve;
        $this->reject = $reject;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.detail.approve-or-reject');
    }
}
