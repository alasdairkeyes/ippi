<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SettingsController extends Controller
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
     * Show the /settings
     *
     * @return \Illuminate\Http\Response
     */
    public function settingsIndex()
    {
            
        return view('settings.index', []);
    }


    /**
     * Handle post for the /settings path
     *
     * @return \Illuminate\Http\Response
     */
    public function settingsIndexPost(Request $request)
    {

        if ($request->password && $request->password_confirmation) {

            $this->validate($request, [
                'password' => 'required|min:6|confirmed',
            ]);

            $user = $request->user();
            $user->password = bcrypt($request->password);
            $user->save();
            $request->session()->flash('alert-success', 'Updated succesfully!');

        }
        return redirect('/settings');
            
    }
}
