<?php

namespace App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Personal_token;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    function login(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message'=>['These credentials do not match.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user'=> $user,
            'token'=>$token
        ];

        return  response($response, 200);
    }

    public function users(Request $request)
    {
        $user = $request->user();
    
        return ['user'=> [
            'id' => $user->id,
            'name' => $user->name,
            'email' =>$user->email,
            'roles' => $user->getRoleNames()
        ]];
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['you logged out successfully']);
    }
}
