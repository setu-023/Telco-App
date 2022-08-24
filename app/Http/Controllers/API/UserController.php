<?php

namespace App\Http\Controllers\API;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;


class UserController extends Controller
    {
    public function index()
    {
        $users = User::all();
        return response()->json([
        "success" => true,
        "message" => "User List",
        "data" => $users
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'name' => 'required|min:4',
        'email' => 'required|email',
        'password' => 'required|min:8',
        ]);
        if($validator->fails()){
            return response()->json(['error' => 'Invalid data'], 405);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return response()->json([
        "success" => true,
        "message" => "User created successfully.",
        "data" => $user
        ]);
    } 

    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json([
        "success" => true,
        "message" => "User retrieved successfully.",
        "data" => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $input = $request->all();
        
        //partial update
        if (request()->has('name')) {
            $user->name = request('name');
        } 
        if (request()->has('email')) {
            $user->email = request('email');
        } 
        if (request()->has('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return response()->json([
        "success" => true,
        "message" => "User updated successfully.",
        "data" => $user
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
        "success" => true,
        "message" => "User deleted successfully.",
        "data" => $user
        ]);
    }
}
