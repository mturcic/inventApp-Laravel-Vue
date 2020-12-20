<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\User;

class AppController extends Controller
{
    public function init()
    {
        $user = Auth::user();

        return response()->json(['user' => $user], 200);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], true)) 
        {
           // Log::alert('usao sam u IF');
            return response()->json(Auth::user(), 200);
        }
        else {
            return response()->json(['error' => 'Prijava nije moguća'], 401);
        }
    }

    public function register(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if (isset($user->id)) 
        {
            return response()->json(['error' => 'Korisničko ime već postoji'], 401);
        }

        $user = new User();
        
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        Auth::login($user);

        return response()->json($user, 200);
    }

    public function update(Request $request)
    {
        $user = auth('api')->user();
        
        $user->update($request->all());
        return ['message' => "Success"];
        // $user= Auth::user();

        // $user->update($request->has('password') ? $request->all() : $request->except(['password']));

        // Flash::message('Korisnički podaci su promijenjeni');
        // return Redirect::to('/');
    }

    public function logout()
    {
        Auth::logout();
    }
}