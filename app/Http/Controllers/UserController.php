<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function menu() {
        return view('user.menu');
    }

    public function orders() {
        return view('user.orders');
    }

    public function offers() {
        return view('user.offers');
    }

    public function profile() {
        return view('user.profile');
    }

    public function checkout() {
        return view('user.checkout');
    }
}
