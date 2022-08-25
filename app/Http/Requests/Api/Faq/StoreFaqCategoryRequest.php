<?php

namespace App\Http\Requests\Api\Faq;

use App\Http\Requests\BaseFormRequest;

class StoreFaqCategoryRequest  extends BaseFormRequest
{
    protected $modelName = 'adicionar categoria';

    public function rules(): array
    {
        return [
            'title' => 'required',
            'active' => 'required',
        ];
    }
}
