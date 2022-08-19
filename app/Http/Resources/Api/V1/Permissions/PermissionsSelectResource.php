<?php

namespace app\Http\Resources\Api\V1\Permissions;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionsSelectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'details' => $this->details,
        ];
    }
}
