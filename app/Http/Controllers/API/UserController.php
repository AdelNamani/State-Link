<?php

namespace App\Http\Controllers\API;

use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * Login the user with his email & password
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(
                [
                    'data' => ['token' => $success['token']],
                    'message'=>'success'
                ], 200);
        } else {
            return response()->json(['data'=>null,'message' => 'Unauthorised'], 401);
        }
    }

    /**
     * @param Request $request
     * Register the user
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['role'] = 'citizen';
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        return response()->json(['data' => $success,'message'=>'success'], $this->successStatus);
    }

    /**
     * Get details of the connected user
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['data' => $user,'message'=>'success'], $this->successStatus);
    }
}
