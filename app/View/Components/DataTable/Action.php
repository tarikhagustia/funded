<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class Action extends Component
{
    public $detail;

    public $edit;

    public $delete;

    public $key;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($detail = null, $edit = null, $delete = null)
    {
        $this->detail = $detail;
        $this->edit = $edit;
        $this->delete = $delete;

        if ($this->delete) {
            $this->key = md5($this->delete);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.data-table.action');
    }
}
