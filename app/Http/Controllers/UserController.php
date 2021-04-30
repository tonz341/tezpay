<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function settings() {
        return view('user.settings');
    }

    public function update(Request $request) {
        
        $user = auth()->user();
        
        $user->tezos_address = encrypt($request->address);

        $user->save();

        return $user;
    }
}
