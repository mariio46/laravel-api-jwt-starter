<?php

namespace App\Http\Resources\Permission;

use App\Helpers\PaginationHelperTraits;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    use PaginationHelperTraits;

    public function toArray(Request $request): array
    {
        return [
            'permissions' => PermissionResource::collection($this->collection),
            ...$this->getMetaLinks($this),
        ];
    }
}
