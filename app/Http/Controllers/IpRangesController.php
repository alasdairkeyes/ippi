<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\IpRange;

class IpRangesController extends Controller
{
    /**
     * Show the .
     *
     * @return \Illuminate\Http\Response
     */
    public function ip_ranges_index()
    {
        $ip_ranges = IpRange::all();
        return view('ip_ranges_index', [
            'ip_ranges' => $ip_ranges,
        ]);
    }
}
