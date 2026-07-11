<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Redot\Http\Controllers\Controller;
use Redot\Traits\CanUploadFile;

class TinymceController extends Controller
{
    use CanUploadFile;

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image',
        ]);

        $url = $this->uploadFile(request()->file('file'), 'tinymce');

        return response()->json([
            'location' => $url,
        ]);
    }
}
