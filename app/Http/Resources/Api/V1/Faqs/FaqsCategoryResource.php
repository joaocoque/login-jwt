<?php

namespace App\Http\Resources\Api\V1\Faqs;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqsCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'active' => $this->active,
        ];
    }
}
