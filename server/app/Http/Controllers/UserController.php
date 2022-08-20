<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|unique:users',
                'name' => 'required',
                'lastname' => 'required',
                'password' => 'required|min:8',
            ], [
                'name.required' => 'Name field is required.',
                'password.required' => 'Password field is required.',
                'email.required' => 'Email field is required.',
                'email.email' => 'Email field must be email address.',
                'email.unique' => 'That email is already in use ',

                'password.min' => 'Password has to be 8 character at least',
            ]);
            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);

            return response()->json([
                'status' => 1,
                'msg' => 'User created',

            ]);

        } catch (Exception $e) {

            return response()->json([
                'status' => 0,
                'msg' => $e->getMessage(),
            ]);

        }

    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => 'Email field is required.',
                'email.email' => 'Email field must be email address.',
                'password.required' => 'Password is required',
            ]);

            $user = User::where('email', '=', $request->email)->first();

            if (isset($user->id)) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()->json([
                        'status' => 1,
                        'token' => $token,
                    ], 200);
                }
            }
            return response()->json([
                'status' => 0,
                'msg' => "Email or password are incorrect",
            ], 401);

        } catch (\Throwable$th) {
            return response()->json([
                'status' => 0,
                'msg' => $th->getMessage(),
            ]);
        }

    }
}
