<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Owner;

class IpOwnersController extends Controller
{
    /**
     * Show the .
     *
     * @return \Illuminate\Http\Response
     */
    public function ip_owners_index()
    {
        $ip_owners = Owner::all();
        return view('ip_owners_index', [
            'ip_owners' => $ip_owners,
        ]);
    }
}
