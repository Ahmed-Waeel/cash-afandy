<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Contracts\View\View;
use Redot\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     *
     * @return View
     */
    public function __invoke()
    {
        return view('dashboard.index');
    }
}
