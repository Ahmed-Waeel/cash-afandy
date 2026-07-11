<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class Attachments extends Component
{
    /**
     * View path for the component.
     */
    public string $view = 'components.attachments';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $id,
        public array $attachments,
        public ?string $title = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->id ??= uniqid('attachments-');

        return view($this->view);
    }

    /**
     * Get the file icon for the given MIME type.
     */
    public function getFileIcon(string $mimeType): string
    {
        return match ($mimeType) {
            'application/pdf' => 'fa-file-pdf',
            'application/msword' => 'fa-file-word',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'fa-file-word',
            'application/vnd.ms-excel' => 'fa-file-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'fa-file-excel',
            'application/vnd.ms-powerpoint' => 'fa-file-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'fa-file-powerpoint',
            'application/zip' => 'fa-file-archive',
            'application/x-rar-compressed' => 'fa-file-archive',
            'application/x-7z-compressed' => 'fa-file-archive',
            'text/plain' => 'fa-file-alt',
            'text/html' => 'fa-file-code',
            'text/css' => 'fa-file-code',
            'text/javascript' => 'fa-file-code',
            'application/json' => 'fa-file-code',
            'video/' => 'fa-file-video',
            'audio/' => 'fa-file-audio',
            default => 'fa-file',
        };
    }

    /**
     * Format the file size.
     */
    public function formatFileSize(int $size): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $index = 0;

        while ($size >= 1024 && $index < count($units) - 1) {
            $size /= 1024;
            $index++;
        }

        return round($size, 2) . ' ' . $units[$index];
    }
}
