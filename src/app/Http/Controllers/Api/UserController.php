<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserApiRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function login(Request $request) {
        $token = auth('api')->attempt($request->all());

        if (empty($token)) {
            return response()->json([], 401);
        }

        $user = auth('api')->user();

        return response()->json([
            'data' => [
                'token' => $token,
                'user' => $user->toArray(),
            ]
        ]);
    }

    public function store(UserApiRequest $request) {
        $user = User::create($request->toArray());

        return response()->json([
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function update(UserApiRequest $request, User $user) {
        $this->authorize('update', $user);

        $user->fill($request->toArray());
        $user->save();

        return response()->json([
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function index() {
        return response()->json([
            'data' => [
                'user' => auth('api')->user(),
            ]
        ]);
    }
}
