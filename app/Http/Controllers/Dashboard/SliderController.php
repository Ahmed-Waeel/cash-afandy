<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Slider;
use Illuminate\Http\Request;
use Redot\Http\Controllers\Controller;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.sliders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validated($request);

        Slider::create($validated);

        return $this->created(__('Slider'), 'dashboard.sliders.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('dashboard.sliders.edit', [
            'slider' => $slider,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $validated = $this->validated($request, $slider);

        $slider->update($validated);

        return $this->updated(__('Slider'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();

        return $this->deleted(__('Slider'));
    }

    /**
     * Get the validated data for the resource.
     */
    protected function validated(Request $request, ?Slider $slider = null)
    {
        $validated = $request->validate([
            'locale' => 'required|in:' . implode(',', setting('website_locales')),
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'foreground' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}([0-9A-Fa-f]{2})?$/',
            'background' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}([0-9A-Fa-f]{2})?$/',
            'background_size' => 'required|in:cover,contain',
            'image' => 'required|string',
            'buttons' => 'nullable|array',
            'buttons.*.type' => 'required|string|in:primary,secondary,success,danger,warning,info',
            'buttons.*.label' => 'required|string|max:255',
            'buttons.*.url' => 'required|url',
        ]);

        // Append the active status to the validated data
        $validated['active'] = $request->has('active');

        $validated['foreground'] = $validated['foreground'] ?? '#ffffff';
        $validated['background'] = $validated['background'] ?? '#00000080';

        return $validated;
    }
}
