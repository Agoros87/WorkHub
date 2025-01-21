<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;

class PageHomeController extends Controller
{
    public function __invoke()
    {
        $advertisements = Advertisement::all();
        return view('welcome', compact('advertisements'));
    }
}
