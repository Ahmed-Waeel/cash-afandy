<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\ComponentAttributeBag;

class Uploader extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.uploader';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $hint = null,
        public array|string|Collection|null $value = null,
        public string $directory = 'general',
        public string $accept = '*',
        public string $serverValidation = '',
        public bool $optimize = true,
        public bool $thumbnail = true,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('uploader-');

        // Convert array to JSON string
        if (is_array($this->value) || $this->value instanceof Collection) {
            $this->value = json_encode($this->value, JSON_UNESCAPED_UNICODE);
        }

        return function (): View {
            $this->attributes(function (ComponentAttributeBag $attributes) {
                $attributes = $attributes->merge([
                    'init' => 'uploader',
                    'uploader-accept' => $this->accept,
                    'uploader-config' => $this->getUploaderConfig(),
                ]);

                return $attributes;
            });

            return view($this->view, [
                'required' => str_contains($this->attributes->get('validation') ?: '', 'required'),
            ]);
        };
    }

    /**
     * Get the uploader data.
     */
    protected function getUploaderConfig(): string
    {
        $data = [
            'accept' => $this->accept,
            'directory' => $this->directory,
            'locale' => app()->getLocale(),
            'serverValidation' => $this->serverValidation,
            'optimize' => $this->optimize,
            'thumbnail' => $this->thumbnail,
        ];

        return encrypt(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
