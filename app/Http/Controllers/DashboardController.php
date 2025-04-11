<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->get();
        return view('dashboard', compact('posts'));
    }
}
