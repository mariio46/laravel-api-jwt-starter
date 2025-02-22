<?php

namespace App\Http\Resources\User;

use App\Helpers\PaginationHelperTraits;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    use PaginationHelperTraits;

    public function toArray(Request $request): array
    {
        return [
            'users' => UserResource::collection($this->collection),
            ...$this->getMetaLinks($this),
        ];
    }
}
