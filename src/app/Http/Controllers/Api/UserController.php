<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserApiRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $token = auth('api')->attempt($credentials);

        if (empty($token)) {
            return response()->json([], 401);
        }

        $user = auth('api')->user();

        return response()->json([
            'data' => [
                'token' => $token,
                'user' => $user->toArray(),
            ],
        ]);
    }

    public function store(UserApiRequest $request)
    {
        $data = $request->only(['name', 'email', 'password', 'default_currency_id']);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user = User::create($data);

        return response()->json([
            'data' => [
                'user' => $user,
            ],
        ]);
    }

    public function update(UserApiRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->only(['name', 'email', 'password', 'default_currency_id']);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->fill($data);
        $user->save();

        return response()->json([
            'data' => [
                'user' => $user,
            ],
        ]);
    }

    public function index()
    {
        return response()->json([
            'data' => [
                'user' => auth('api')->user(),
            ],
        ]);
    }
}
