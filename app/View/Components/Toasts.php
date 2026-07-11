<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class Toasts extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.toasts';

    /**
     * The toastify configuration.
     */
    public array $config;

    /**
     * The session-flashed toasts, pulled so they only render once.
     */
    public array $messages;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->config = config('toastify', []);
        $this->messages = session()->pull('toastify', []);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view($this->view);
    }
}
