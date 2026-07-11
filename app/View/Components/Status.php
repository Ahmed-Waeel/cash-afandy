<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class Status extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.status';

    /**
     * The status types.
     */
    const STATUS = [
        'success',
        'error',
        'warning',
        'info',
    ];

    /**
     * The status of the component.
     */
    public ?string $status = null;

    /**
     * The color of the component.
     */
    public ?string $color = null;

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        foreach (self::STATUS as $status) {
            if (session()->has($status)) {
                $this->status = $status;

                return view($this->view);
            }
        }

        return '';
    }
}
