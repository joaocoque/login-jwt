<?php

namespace app\Http\Resources\Api\V1\Roles;

use Illuminate\Http\Resources\Json\JsonResource;

class RolesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
        ];
    }
}
