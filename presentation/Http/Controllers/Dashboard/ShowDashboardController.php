<?php

namespace Presentation\Http\Controllers\Dashboard;

use Illuminate\Contracts\View\View;
use Presentation\Http\Controllers\Controller;

class ShowDashboardController extends Controller
{
    public function execute(): View
    {
        return view('dashboard.index');
    }
}
