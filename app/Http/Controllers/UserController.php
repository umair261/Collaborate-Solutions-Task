<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signup(UserStoreRequest $req)
    {

        $new = new User;
        $new->name = $req->input('name');
        $new->father_name = $req->input('father_name');
        $new->email = $req->input('email');
        $new->password = Hash::make($req->input('password'));
        $new->address = $req->input('address');
        $new->created_at = now();
        $new->updated_at = now();
        $new->save();
        return response()->json(['message' => 'Successfully data entered user'], 201);

    }

    public function login(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();
        if ($user) {

            if (Hash::check($password, $user->password)) {
                $token = $user->createToken($user->email)->plainTextToken;

                return response()->json(['message' => 'Login successful', 'token' => $token], 200);
            } else {
                return response()->json([
                    'error' => 'Enter a valid password',
                ], 401);
            }

        } else {
            return response()->json([
                'error' => 'Invalid email ',
            ], 401);
        }
    }
    public function logout(Request $request)
    {

        $user = $request->user();

        $user->tokens()->delete();

        return response()->json(['message' => 'Logout successful'], 200);

    }
    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            return response()->json(["message" => "Deleted data"], 201);
        } else {
            return response()->json(['error' => 'User not found']);
        }
    }

    public function update(UserStoreRequest $request, $id)
    {
        $user = User::where('id', $id)->first();

        if ($user) {
            $user->name = $request->input('name');
            $user->father_name = $request->input('father_name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->address = $request->input('address');

            $user->save();
            return response()->json(['message' => 'User record updated successfully'], 201);
        } else {
            return response()->json(['message' => 'User record not found'], 404);
        }
    }

}
