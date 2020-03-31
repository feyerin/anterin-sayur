<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function checkRole()
    {
        $user = Auth::user();
        $userRole = $user->role;
        
        return $userRole;
    }

    public function indexProduct()
    {
        $role = $this->checkRole();
        if($role == 1) {
            return view('app.product.index');
        } else {
            return ("You shall not pass");
        }
    }

    public function indexOrder()
    {
        $role = $this->checkRole();
        if($role == 1) {
            return view('app.order.index');
        } else {
            return ("You shall not pass");
        }
    }

    public function indexBanner()
    {
        $role = $this->checkRole();
        if($role == 1) {
            return view('app.banner.index');
        } else {
            return ("You shall not pass");
        }
    }

    public function addProduct()
    {
        $role = $this->checkRole();
        if($role == 1) {
            return view('app.product.add');
        } else {
            return ("You shall not pass");
        }
    }

    public function readProduct()
    {
        $role = $this->checkRole();
        if($role == 1) {
            return view('app.product.detail');
        } else {
            return ("You shall not pass");
        }
    }

    public function readOrder()
    {
        $role = $this->checkRole();
        if($role == 1) {
            return view('app.order.detail');
        } else {
            return ("You shall not pass");
        }
    }

    public function addBanner()
    {
        $role = $this->checkRole();
        if($role == 1) {
            return view('app.banner.add');
        } else {
            return ("You shall not pass");
        }
    }

    public function readBanner()
    {
        $role = $this->checkRole();
        if($role == 1) {
            return view('app.banner.detail');
        } else {
            return ("You shall not pass");
        }
    }
}
