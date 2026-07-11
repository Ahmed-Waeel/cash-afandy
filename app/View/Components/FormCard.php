<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class FormCard extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.form-card';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $resource,
        public mixed $entry = null,
        public array $data = [],
        public ?string $title = null,
        public ?string $submit = null,
        public ?string $action = null,
        public ?string $method = null,
        public ?string $route = null,
        public array $routeParams = [],
        public string|null|false $back = null,
        public array $backParams = [],
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Heading and primary button label: edit/update when an entry exists, otherwise create.
        $this->title ??= $this->entry ? __('Edit') : __('Create');
        $this->submit ??= $this->entry ? __('Update') : __('Create');

        // When no explicit URL is passed, resolve `dashboard.{resource}.store|update` and build the action.
        if (! $this->action) {
            // Route name suffix matches Laravel conventions: store for new records, update for existing.
            $this->route ??= "dashboard.$this->resource." . ($this->entry ? 'update' : 'store');

            // Update routes expect the model (or key) as the last route parameter; merge it into `params`.
            if ($this->entry) {
                $this->routeParams = array_merge($this->routeParams, [$this->entry]);
            }

            // Build the action URL using the route and params.
            $this->action = route($this->route, $this->routeParams);
        }

        // Form method: PUT for updates, POST for creates.
        $this->method ??= $this->entry ? 'PUT' : 'POST';

        // Back link defaults to the resource index route name.
        $this->back ??= "dashboard.$this->resource.index";

        // If the page is inline, unset the back link.
        if (request()->has('inline')) $this->back = null;

        $this->data = array_merge($this->data, [
            'entry' => $this->entry,
        ]);

        return view($this->view, $this->data);
    }
}
