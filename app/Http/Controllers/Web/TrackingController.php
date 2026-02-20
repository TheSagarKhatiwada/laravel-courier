<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function publicTrack(Request $request)
    {
        $request->validate(['awb' => 'required|string']);
        return redirect()->route('track.show', $request->awb);
    }

    public function show(string $awb)
    {
        $shipment = Shipment::with(['trackings' => function ($q) {
            $q->orderBy('tracked_at', 'desc');
        }, 'branch'])->where('awb_number', $awb)->first();

        return view('welcome', compact('shipment', 'awb'));
    }
}
