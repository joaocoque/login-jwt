<?php

namespace app\Http\Resources\Api\V1\Roles;

use App\Http\Resources\Api\V1\Permissions\PermissionsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'permissions' => PermissionsResource::collection($this->permissions)
        ];
    }
}
