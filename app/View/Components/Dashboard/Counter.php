<?php

namespace App\View\Components\Dashboard;

use Cache;
use Illuminate\View\Component;

class Counter extends Component
{
    public $id;

    public $label;

    public $value;

    /**
     * Background class
     *
     * @var string
     */
    public $color;

    /**
     * chart.js data
     *
     * @var array
     */
    public $chartData;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = null, $label = 'Label', $value = 0, $color = 'bg-gradient-primary')
    {
        $this->id = $id;
        $this->label = $label;
        $this->value = $value;
        $this->color = $color;

        if ($this->id == null) {
            $this->id = \Illuminate\Support\Str::uuid();
        }

        $this->chartData = array_map(function ($i) {
            return rand(50, 80);
        }, range(0, 7));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.counter');
    }
}
