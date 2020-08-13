<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class ReportsController extends Controller
{
    public function monthFlow() {
        return view('pages.reports.month_flow');
    }
}
