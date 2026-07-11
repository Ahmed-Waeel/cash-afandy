<?php

namespace App\Http\Controllers\Website;

use App\Models\StaticPage;
use Redot\Http\Controllers\Controller;

class StaticPageController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(StaticPage $staticPage)
    {
        return view('website.static-pages.show', [
            'staticPage' => $staticPage,
        ]);
    }
}
