<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'device_name' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $user->createToken($request->device_name)->plainTextToken;

    }

    public function login(Request $request){

        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]); 

        }
        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function logout(Request $request){
        $user = User::where('email', $request->email)->first();
        if($user){
            $user->tokens()->delete();    
        }
        return response()->NoContent();

    }
}
