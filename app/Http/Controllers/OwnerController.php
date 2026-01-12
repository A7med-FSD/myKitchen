<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function dashboard()
    {
        return view('owner.dashboard');
    }

    public function orders()
    {
        return view('owner.orders');
    }

    public function menu()
    {
        return view('owner.menu');
    }

    public function inventory()
    {
        return view('owner.inventory');
    }

    public function analytics()
    {
        return view('owner.analytics');
    }

    public function customers()
    {
        return view('owner.customers');
    }

    public function settings()
    {
        return view('owner.settings');
    }
    
    public function notifications()
    {
        return view('owner.notifications');
    }
    
    public function promotions()
    {
        return view('owner.promotions');
    }
    
}
