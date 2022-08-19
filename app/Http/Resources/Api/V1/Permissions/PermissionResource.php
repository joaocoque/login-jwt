<?php

namespace app\Http\Resources\Api\V1\Permissions;

use App\Http\Resources\Api\V1\Roles\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'roles' => RoleResource::collection($this->roles),
        ];
    }
}
