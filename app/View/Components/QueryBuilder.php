<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\ComponentAttributeBag;
use Redot\Support\QueryFilters;

class QueryBuilder extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.query-builder';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $hint = null,
        public ?string $model = null,
        public array|string|null $value = null,
        public array|string|null $filters = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('query-builder-');

        // Convert array to JSON string
        if (is_array($this->value) || $this->value instanceof Collection) $this->value = json_encode($this->value, JSON_UNESCAPED_UNICODE);

        $this->filters = QueryFilters::resolve($this->model, $this->filters);

        return function (): View {
            $this->attributes(function (ComponentAttributeBag $attributes) {
                return $attributes->merge(['query-filters' => is_array($this->filters) ? json_encode($this->filters, JSON_UNESCAPED_UNICODE) : $this->filters]);
            });

            return view($this->view, [
                'required' => str_contains($this->attributes->get('validation') ?: '', 'required'),
            ]);
        };
    }
}
