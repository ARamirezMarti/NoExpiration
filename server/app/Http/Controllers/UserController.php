<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    

    public function register(Request $request){
            try{
        $validated= $request->validate([
                'email'=>'required|email',
                'name'=>'required',
                'lastname'=>'required',
                'password'=>'required|min:8',
            ],[
                'name.required' => 'Name field is required.',
                'password.required' => 'Password field is required.',
                'email.required' => 'Email field is required.',
                'email.email' => 'Email field must be email address.',
                'password.min'=> 'Password has to be 8 character at least'
            ]);
            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);

        }catch(Exception $e){
            
           if(isset($e->errorInfo[1])){

               $error_code=$e->errorInfo[1];
               
               switch ($error_code) {
                   case '1062':
                       return response()->json([
                           'status' => 0,
                           'msg' => 'That email is already in use   .',                     
                                                   
                           'error_code'=>$e->errorInfo[1]
                       ]);
                       break;
                   
                   default:
                       break;
               } 
           }else{

               return response()->json([
                   'status' => 0,
                   'msg' => $e->getMessage(),
               ]);
           }
        }
        return response()->json([
            'status' => 1,
            'msg' => 'User created',
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
      
        $user = User::where('email','=',$request->email)->first();
        if( isset($user->id)){
            if(Hash::check($request->password,$user->password)){
                $token= $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                        'status' => 1,
                        'token'=>$token,
                    ],200);
            }
        }
        return response()->json([
            'status' => 0,
            'msg' => "Email or password are incorrect",
        ]);
 
    
        
    }
}
