<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class OwnerScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $userId = Auth::id();

        if (empty($userId)) {
            throw new UserNotDefinedException('User not logged in');
        }

        $builder->where($model->getTable().'.user_id', $userId);
    }
}
