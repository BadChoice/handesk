<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index() {
        return view('home', ["tickets" => auth()->user()->tickets ]);
    }
}
