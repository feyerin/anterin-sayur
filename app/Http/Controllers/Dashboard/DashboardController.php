<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('app.product.index');
    }

    public function add()
    {
        return view('app.product.add');
    }

    public function read()
    {
        return view('app.product.detail');
    }
}
