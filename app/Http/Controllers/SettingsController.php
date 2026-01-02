<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SettingsController extends Controller
{
    public function change_user_settings(Request $request)
{
    $validated = $request->validate([
        'key' => 'required',
        'value' => 'required',
    ]);

    Auth::user()
        ->settings()
        ->updateOrCreate(
            [
                'user_id' => Auth::id(),         // match user
                'key' => $validated['key']       // match specific key
            ],
            [
                'value' => $validated['value']   // update or insert value
            ]
        );

    return redirect()->back()->with('success', 'Settings Updated');
}

}
