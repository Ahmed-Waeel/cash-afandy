<?php

namespace App\Http\Controllers\Website;

use Redot\Http\Controllers\Controller;

class HealthCheckController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return view('website.health-check');
    }
}
