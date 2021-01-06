<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Orion\Http\Controllers\Controller as Controller;
use Orion\Http\Requests\Request;

class CategoryController extends Controller
{
    protected $model = Category::class;

    protected $request = CategoryRequest::class;

    protected function buildIndexFetchQuery(
        Request $request,
        array $requestedRelations
    ): Builder {
        return Category::allForUser();
    }

    /**
     * Fills attributes on the given entity and stores it in database.
     *
     * @param Request $request
     * @param Model $post
     * @param array $attributes
     */
    protected function performStore(
        Request $request,
        Model $entity,
        array $attributes
    ): void {
        $entity->fill($attributes);
        $entity->user_id = Auth::user()->id;
        $entity->save();
    }

    protected function performUpdate(
        Request $request,
        Model $entity,
        array $attributes
    ): void {
        $entity->category = $attributes['category'];
        $entity->save();
    }
}
