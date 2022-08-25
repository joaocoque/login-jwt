<?php

namespace App\Http\Requests\Api\Faq;

use App\Http\Requests\BaseFormRequest;

class UpdateFaqRequest  extends BaseFormRequest
{
    protected $modelName = 'atualizar pergunta';

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
