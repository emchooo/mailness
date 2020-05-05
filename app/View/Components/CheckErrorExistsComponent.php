<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckErrorExistsComponent extends Component
{
    /** @var string $controlName */

    public $controlName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($controlName)
    {
        $this->controlName = $controlName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.check-error-exists-component');
    }
}
