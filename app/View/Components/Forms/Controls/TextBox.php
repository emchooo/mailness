<?php

namespace App\View\Components\Forms\Controls;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class TextBox extends Component
{
    /**
     * Control name of Textbox.
     *
     * @var string
     */
    public $controlName;

    /**
     * Text to display for label.
     *
     * @var string
     */
    public $labelText;

    /**
     * Placeholder Message.
     *
     * @var string|null
     */
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @param  string  $controlName
     * @return void
     */
    public function __construct(
        string $controlName,
        ?string $labelText = null,
        ?string $placeholder = null
        ) {
        $this->controlName = $controlName;
        $this->labelText = is_null($labelText) ? Str::of($controlName)->title()->replace('_', ' ') : $labelText;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.controls.text-box');
    }
}
