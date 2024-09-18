<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
   
    public function register(Request $request){
        $isValide = Validator::make($request->all(),[
            "name"=> "required",
            "email"=> "required|email|unique:users",
            "password"=> "required|confirmed",
        ]);
        if($isValide->fails()){
            return response()->json([
                "error"=> $isValide->messages(),
            ]);
        }
        $user = User::create([
            "name"=> $request->name,
            "email"=> $request->email,
            "password"=> bcrypt($request->password),
        ]);
        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json([
            "message"=>"User Created Successfully",
            "token"=> $token,
        ]);
    }

    public function login(Request $request){
        $isvalide = Validator::make($request->all(),[
            "email"=> "required|email",
            "password"=> "required",
        ]);

        if($isvalide->fails()){
            return response()->json([
                "error"=> $isvalide->messages(),
            ]);
        }
        $user = User::where("email", $request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken($request->email)->plainTextToken;
                return response()->json([
                    "message"=> "You're login",
                    "token"=> $token
                ]);
            }
            else{
                return response()->json([
                    "error"=> "Wrong Password try again"
                ]);
            }
        }
        else{
            return response()->json([
                "error"=> "User doesn't exist"
            ]);
        }
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            "message"=> "You're logged out"
        ]);
    }
}
