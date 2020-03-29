<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function indexProduct()
    {
        return view('app.product.index');
    }

    public function indexOrder()
    {
        return view('app.order.index');
    }

    public function addProduct()
    {
        return view('app.product.add');
    }

    public function readProduct()
    {
        return view('app.product.detail');
    }
}
