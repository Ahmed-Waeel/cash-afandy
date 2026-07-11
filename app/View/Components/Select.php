<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use Illuminate\View\ComponentAttributeBag;
use InvalidArgumentException;

class Select extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.select';

    /**
     * Create the component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $hint = null,
        public array|Collection $options = [],
        public array|string|null $value = [],
        public bool $tom = true,
        public bool $floating = false,

        // Query related attributes.
        public EloquentBuilder|QueryBuilder|string|null $query = null,
        public array|string $search = [],
        public array|string $appends = [],
        public string $key = 'id',
        public string $text = 'name',
        public ?string $template = null,
        public ?string $create = null,
        public array $createParams = [],
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('select-');

        // If the value is csv, we will convert it to an array.
        if (! is_array($this->value)) {
            $this->value = is_string($this->value) ? explode(',', $this->value) : [$this->value];
            $this->value = parse_csv($this->value);
        }

        // If the search is a csv, we will convert it to an array.
        if (is_string($this->search)) {
            $this->search = parse_csv($this->search);
        }

        // If the appends is a csv, we will convert it to an array.
        if (is_string($this->appends)) {
            $this->appends = parse_csv($this->appends);
        }

        // If the query is a string and a class exists, we will instantiate the class and get the query.
        if (is_string($this->query) && class_exists($this->query)) {
            $this->query = app($this->query)->query();
        }

        // If template doesn't start with `templates.select`, we will prefix it.
        if ($this->template && ! str_starts_with($this->template, 'templates.select')) {
            $this->template = 'templates.select.' . $this->template;
        }

        // Disable tom select if floating is true.
        if ($this->floating) {
            $this->tom = false;
        }

        // If create is set and select is not a query, throw an exception.
        if ($this->create && ! $this->query) {
            throw new InvalidArgumentException('The create attribute is only supported when the query attribute is set.');
        }

        // Append required params to the create route.
        if ($this->create) {
            $this->createParams = array_merge($this->createParams, [
                'inline' => true,
                'keep' => ['from-select' => $this->id],
            ]);
        }

        return function (): View {
            $this->attributes(function (ComponentAttributeBag $attributes) {
                $attributes = $attributes->class(['form-select']);

                if ($this->tom) {
                    $attributes = $attributes->merge(['init' => 'tomselect']);
                }

                if ($this->query) {
                    $attributes = $attributes->merge([
                        'select-query' => $this->getQueryData(),
                        'select-query-route' => route('global.select.search'),
                        'select-fetch-route' => route('global.select.fetch'),
                        'select-search-field' => json_encode($this->search),
                        'select-preload-values' => implode(',', $this->value),
                    ]);
                }

                return $attributes;
            });

            return view($this->view, [
                'required' => str_contains($this->attributes->get('validation') ?: '', 'required'),
            ]);
        };
    }

    /**
     * Get the query data as encrypted string.
     */
    protected function getQueryData(): string
    {
        $search = $this->search;
        $columns = array_values(array_unique(array_merge($search, [$this->key, $this->text])));

        $term = uniqid('term_');
        $query = $this->query->clone()->select($this->key);
        $query = search_model($query, $columns, sprintf('{%s}', $term));

        if ($this->template && ! view()->exists($this->template)) {
            throw new InvalidArgumentException(sprintf('The template [%s] does not exist.', $this->template));
        }

        $data = [
            'key' => $this->key,
            'text' => $this->text,
            'template' => $this->template,

            'query' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'model' => get_class($query->getModel()),

            'term' => $term,
            'columns' => $columns,
            'appends' => $this->appends,
        ];

        return encrypt(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
