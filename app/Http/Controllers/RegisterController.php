<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'photo' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $ext1 = $file->getClientOriginalExtension();
            $image = time().'.'.$ext1;
            $file->move('assets/profiles/', $image);
            $user->profile = $image;
        }
        $user->status = 'online';
        $user->save();

    }
}
