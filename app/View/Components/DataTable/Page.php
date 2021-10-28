<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class Page extends Component
{
    public $title;

    public $dataTable;

    public $dates;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $dataTable, array $dates = null)
    {
        $this->title = $title;
        $this->dataTable = $dataTable;
        $this->dates = $dates;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.data-table.page');
    }
}
