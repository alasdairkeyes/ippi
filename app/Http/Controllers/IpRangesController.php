<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\IpRange;
use App\Owner;

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


    /**
     * Show the /ip_ranges/add path
     *
     * @return \Illuminate\Http\Response
     */
    public function ip_ranges_add(Request $request)
    {

        return view('ip_ranges_add', [
            'ip_owners' => $ip_owners = Owner::all(),
        ]);
    }

    /**
     * Post the /ip_ranges/add path
     *
     * @return \Illuminate\Http\Response
     */
    public function ip_ranges_add_post(Request $request)
    {

        // Validate the name
        $this->validate($request, [
            'network'   => 'required|ip',
            'cidr'      => 'required|integer',
            'owner_id'  => 'required|integer',
        ]);

        // Validate Owner
        $ip_owner = Owner::where('id',$request->owner_id)->first();
        if (!$ip_owner) {
            return redirect()->back()->withInput()->withErrors(['owner_id' => "This owner doesn't exist"]);
        }

        // Validate IP Range supplied
        $ip_block = null;
        try {
            $ip_block = \IPBlock::create($request->network, $request->cidr);
        } catch (Exception $e) {
                return redirect()->back()->withInput()->withErrors([
                    'network'   => 'Invalid network/cidr combination',
                    'cidr'      => 'Invalid network/cidr combination'
                ]);
        }

        // Make sure customer's other ranges don't conflict
        foreach ($ip_owner->ip_ranges as $existing_ip_range) {

            if ($existing_ip_range->is_in_ip_range($ip_block)) {
                return redirect()->back()->withInput()->withErrors(['network' => "IP Range is contains an existing range " . $existing_ip_range->network_cidr() ]);
            }
            if ($existing_ip_range->contains_ip_range($ip_block)) {
                return redirect()->back()->withInput()->withErrors(['network' => "IP Range is contained in existing range " . $existing_ip_range->network_cidr() ]);
            }
        }

        // Create/Insert
        $ip_range = $ip_owner->ip_ranges()->create([
            'network'       => $request->network,
            'cidr'          => $request->cidr,
            'ip_version'    => $ip_block->getFirstIp()->getVersion(),
        ]);

        // Redirect back to Ip Ranges page
        return redirect('/ip_ranges');

    }
}
