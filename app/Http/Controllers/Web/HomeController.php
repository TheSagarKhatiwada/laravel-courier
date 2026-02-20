<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\CourierRate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('web.home', compact('branches'));
    }

    public function trackPage()
    {
        return view('web.track');
    }

    public function services()
    {
        return view('web.services');
    }

    public function branches()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('web.branches', compact('branches'));
    }

    public function contact()
    {
        return view('web.contact');
    }

    public function rates()
    {
        $branches = Branch::where('is_active', true)->get();
        $rates = CourierRate::with('branch')->where('is_active', true)->get();
        return view('web.rates', compact('branches', 'rates'));
    }
}
