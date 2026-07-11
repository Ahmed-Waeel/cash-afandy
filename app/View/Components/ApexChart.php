<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\ComponentAttributeBag;

class ApexChart extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.apex-chart';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public array|string|Collection|null $series = [],
        public array|string|Collection|null $options = [],
        public ?string $type = null,
        public string|int|null $height = null,
        public string|int|null $width = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('apex-chart-');

        $options = $this->normalizeOptions($this->options);
        $series = $this->normalizeOptions($this->series);

        if ($series !== []) {
            $options['series'] = $series;
        }

        if ($this->type) {
            data_set($options, 'chart.type', $this->type);
        }

        if ($this->height !== null) {
            data_set($options, 'chart.height', $this->height);
        }

        if ($this->width !== null) {
            data_set($options, 'chart.width', $this->width);
        }

        return function () use ($options): View {
            $this->attributes(function (ComponentAttributeBag $attributes) use ($options) {
                return $attributes->merge([
                    'apex-chart' => json_encode($options, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ]);
            });

            return view($this->view);
        };
    }

    /**
     * Normalize chart options from arrays, collections, or JSON strings.
     */
    protected function normalizeOptions(array|string|Collection|null $options): array
    {
        if ($options instanceof Collection) {
            return $options->toArray();
        }

        if (is_array($options)) {
            return $options;
        }

        if (is_string($options) && trim($options) !== '') {
            $decoded = json_decode($options, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }
}
