<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\IpRange;
use App\Owner;

include_once(app_path().'/Utils.php');

use function App\Utils\validHostname;

class IpRangesController extends Controller
{
    /**
     * Show the .
     *
     * @return \Illuminate\Http\Response
     */
    public function ipRangesIndex()
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
    public function ipRangesAdd(Request $request)
    {

        return view('ip_ranges_add', [
            'ip_owners' => Owner::all(),
        ]);
    }

    /**
     * Post the /ip_ranges/add path
     *
     * @return \Illuminate\Http\Response
     */
    public function ipRangesAddPost(Request $request)
    {

        // Validate the name
        $this->validate($request, [
            'network'   => 'required|ip',
            'cidr'      => 'required|integer',
            'owner_id'  => 'required|integer',
        ]);

        // Validate Owner
        $ipOwner = Owner::where('id',$request->owner_id)->first();
        if (!$ipOwner) {
            return redirect()->back()->withInput()->withErrors(['owner_id' => "This owner doesn't exist"]);
        }

        // Validate IP Range supplied
        $ipBlock = null;
        try {
            $ipBlock = \IPBlock::create($request->network, $request->cidr);
        } catch (Exception $e) {
                return redirect()->back()->withInput()->withErrors([
                    'network'   => 'Invalid network/cidr combination',
                    'cidr'      => 'Invalid network/cidr combination'
                ]);
        }

        // Make sure customer's other ranges don't conflict
        foreach ($ipOwner->ipRanges as $existingIpRange) {

            if ($existingIpRange->isInIpRange($ipBlock)) {
                return redirect()->back()->withInput()->withErrors(['network' => "IP Range is contains an existing range " . $existingIpRange->networkCidr() ]);
            }
            if ($existingIpRange->containsIpRange($ipBlock)) {
                return redirect()->back()->withInput()->withErrors(['network' => "IP Range is contained in existing range " . $existingIpRange->networkCidr() ]);
            }
        }

        // Create/Insert
        $ipRange = $ipOwner->ipRanges()->create([
            'network'       => $request->network,
            'cidr'          => $request->cidr,
            'ip_version'    => $ipBlock->getFirstIp()->getVersion(),
        ]);

        // Redirect back to Ip Ranges page
        return redirect('/ip_ranges');

    }


    /**
     * Show the /ip_ranges/{id}/delete path
     *
     * @return \Illuminate\Http\Response
     */
    public function ipRangesDelete($id)
    {

        return view('ip_ranges_delete', [
            'ip_range'  => IpRange::findOrFail($id),
        ]);
    }

    /**
     * Post to the /ip_ranges/{id}/delete path
     *
     * @return \Illuminate\Http\Response
     */
    public function ipRangesDeletePost($id)
    {

        $ipRange = IpRange::findOrFail($id);
        $ipRange->delete();
        return redirect('/ip_ranges');
    }


    /**
     * Show the /ip_ranges/{id} path
     *
     * @return \Illuminate\Http\Response
     */
    public function ipRangesView($id)
    {
        $ipRange =  IpRange::findOrFail($id);
        return view('ip_ranges_view', [
            'ip_range'  => $ipRange,
        ]);
    }


    /**
     * Edit/Update the an IP address
     *
     * @return \Illuminate\Http\Response
     */
    public function ipRangesIpAddressView(Request $request, $id, $ipAddressString) {
        // Get Range
        $ipRange   =  IpRange::findOrFail($id);

        // Get IP Address
        $ipAddress =  $ipRange->ipAddresses()->where('address', $ipAddressString)->first();

        return view('ip_ranges_ip_addresses_view', [
            'ip_range'          => $ipRange,
            'ip_address'        => $ipAddress,
            'ip_address_string' => $ipAddressString,
        ]);
    }

    public function ipRangesIpAddressViewPost(Request $request, $id, $ipAddressString) {
        // Get Range
        $ipRange   =  IpRange::findOrFail($id);

        // Validate the name
        // TODO: Write custom hostname validator
        $this->validate($request, [
            'hostname'      => 'required|string',
            'description'   => 'required|string',
        ]);

        error_log(validHostname($request->hostname));
        if (!validHostname($request->hostname)) {
            return redirect()->back()->withInput()->withErrors(['hostname' => "Invalid Hostname" ]);
        }

        // Get IP Address
        $ipAddress =  $ipRange->ipAddresses()->firstOrNew([
            'address'    => $ipAddressString,
        ]);
//        error_log(print_r($ipAddress,1));
//        dd($ipAddress);
//        exit;

        $ipAddress->fill([
            'hostname'      => $request->hostname,
            'description'   => $request->description,
        ]);
        $ipAddress->save();


        return redirect('/ip_ranges/' . $ipRange->id);
    }
}
