<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ToastMessage extends Component
{
    public $type;
    public $message;

    /**
     * Create a new component instance.
     *
     * @param string $type
     * @param string $message
     */
    public function __construct($type = 'success', $message = 'Notification message goes here')
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.toast-message');
    }
}
