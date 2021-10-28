<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class DateRangeFilter extends Component
{
    public $dates;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($dates)
    {
        $this->dates = $dates;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.data-table.date-range-filter');
    }
}
