<?php

namespace App\Http\Requests\Api\Faq;

use App\Http\Requests\BaseFormRequest;

class UpdateFaqCategoryRequest  extends BaseFormRequest
{
    protected $modelName = 'atualizar categoria';

    public function rules(): array
    {
        return [
            'title' => 'required',
            'active' => 'required',
        ];
    }
}
