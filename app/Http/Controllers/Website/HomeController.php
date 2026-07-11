<?php

namespace App\Http\Controllers\Website;

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
        return view('website.index');
    }
}
