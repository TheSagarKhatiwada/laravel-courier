<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function trackPage()
    {
        return view('welcome');
    }

    public function services()
    {
        return view('welcome');
    }

    public function branches()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('welcome', compact('branches'));
    }

    public function contact()
    {
        return view('welcome');
    }

    public function rates()
    {
        return view('welcome');
    }
}
