<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

use App\Events\NewUser;

class UserController extends Controller
{
    //
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), 
        [
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'firstName'     => ['required', 'string'],
            'lastName'      => ['required', 'string']
        ]);

        if($validation->fails()){
            return response()->json([
                'status'    => false,
                'message'   => "User creation failed",
                'error'     => $validation->errors()
            ], 400);
        }

        $user = User::create([
            'email' => $request->email,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName
        ]);

        if($user){
            NewUser::dispatch($user);

            return response()->json([
                'status'  => true,
                'message' => "Success"
            ], 200);
        }

        return response()->json([
            'status'  => false,
            'message' => "Unknown Server Error"
        ], 500);
    }
}
