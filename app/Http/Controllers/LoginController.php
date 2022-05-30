<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|min:6'
        ]);
        if(Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request->email)->first();
            $user->status = 'online';
            $user->save();
            return  Auth::user();
        }
    }
    public function logoutuser(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        if($user) {
            $user->status = 'offline';
            $user->save();
            Auth::logout();
        }
    }
    public function usermail(Request $request) {
        $user = User::where('name', $request->user_mail)->orWhere('email', $request->user_mail)->exists();
        if(!$user){
            return response()->json([
                'status' => 400,
                'msg' => 'invalid username or email address'
            ]);
        }else{
            return response()->json([
                'status' => 200,
                'msg' => 'username / email exists'
            ]);
        }
    }
}
