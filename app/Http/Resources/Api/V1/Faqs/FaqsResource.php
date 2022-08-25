<?php

namespace App\Http\Resources\Api\V1\Faqs;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'question' => $this->question,
            'answer' => $this->answer,
            'active' => $this->active,
            'category' => $this->category->title,
        ];
    }
}
