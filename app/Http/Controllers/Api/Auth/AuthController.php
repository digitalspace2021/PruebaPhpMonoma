<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Exception;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        try {
            $data = $request->validated();

            if (!$token = auth()->attempt($data, true)) {
                return response()->error("credential incorrect for user: $request->username", 401);
            }

            return response()->success([
                'token' => $token,
                'minutes_to_expire' => auth()->factory()->getTTL(),
            ], 200);
        } catch (Exception $ex) {
            return response()->error([
                'line' => $ex->getLine(),
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            auth()->logout();
            return response()->success('logged out', 200);
        } catch (Exception $ex) {
            return response()->error([
                'line' => $ex->getLine(),
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}
