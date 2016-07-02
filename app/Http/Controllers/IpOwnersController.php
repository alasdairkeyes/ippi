<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Owner;

class IpOwnersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the /ip_ranges path
     *
     * @return \Illuminate\Http\Response
     */
    public function ipOwnersIndex()
    {
        $ip_owners = Owner::all();
        return view('ip_owners_index', [
            'ipOwners' => $ip_owners,
        ]);
    }


    /**
     * Show the /ip_ranges/add path
     *
     * @return \Illuminate\Http\Response
     */
    public function ipOwnersAdd(Request $request)
    {

        return view('ip_owners_add', []);
    }


    /**
     * Post the /ip_ranges/add path
     *
     * @return \Illuminate\Http\Response
     */
    public function ipOwnersAddPost(Request $request)
    {

        // Validate the name
        $this->validate($request, [
            'name'          => 'required|max:255',
        ]);
        
        // Create/Insert
        $owner = null;
        try {
            $owner = Owner::create([
                'name'          => $request->name,
                'description'   => $request->description,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            // If
            if ($e->errorInfo['0'] == '23000') {
                return redirect()->back()->withInput()->withErrors(['name' => 'This name is already in use']);
                // Duplicate key
            }
        }

        return redirect('/ip_owners/');

    }


    /**
     * Show the /ip_owners/{id}/delete path
     *
     * @return \Illuminate\Http\Response
     */
    public function ipOwnersDelete($id)
    {

        return view('ip_owners_delete', [
            'ipOwner'  => Owner::findOrFail($id),
        ]);
    }


    /**
     * Post to the /ip_owners/{id}/delete path
     *
     * @return \Illuminate\Http\Response
     */
    public function ipOwnersDeletePost($id)
    {

        $ipOwner = Owner::findOrFail($id);
        $ipOwner->delete();
        return redirect('/ip_owners');
    }

}
