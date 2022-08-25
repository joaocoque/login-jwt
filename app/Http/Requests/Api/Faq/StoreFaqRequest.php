<?php

namespace App\Http\Requests\Api\Faq;

use App\Http\Requests\BaseFormRequest;

class StoreFaqRequest  extends BaseFormRequest
{
    protected $modelName = 'adicionar pergunta';

    public function rules(): array
    {
        return [
            'question' => 'required',
            'answer' => 'required',
            'active' => 'required',
            'category_id' => 'required',
        ];
    }
}
