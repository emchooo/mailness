<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ErrorAlertComponent extends Component
{
    /** @var string $errorMessage */
    public $errorMessage;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.error-alert-component');
    }
}
