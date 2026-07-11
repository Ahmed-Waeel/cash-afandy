<?php

namespace App\Http\Controllers\Website;

use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Redot\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the website.
     *
     * @return View
     */
    public function __invoke()
    {
        $sliders = Slider::query()
            ->where('active', true)
            ->where('locale', app()->getLocale())
            ->latest('id')
            ->get();

        return view('website.index', [
            'sliders' => $sliders,
        ]);
    }
}
