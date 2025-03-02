<?php

namespace App\Http\Resources\Role;

use App\Helpers\PaginationHelperTraits;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    use PaginationHelperTraits;

    public function toArray(Request $request): array
    {
        return [
            'roles' => RoleResource::collection($this->collection),
            ...$this->getMetaLinks($this),
        ];
    }
}
