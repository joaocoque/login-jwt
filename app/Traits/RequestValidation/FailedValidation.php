<?php

namespace App\Traits\RequestValidation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FailedValidation
{
    protected $modelName = '';

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Falha ao adicionar',
            'data' => $validator->getMessageBag(),
        ], 400));
    }
}

