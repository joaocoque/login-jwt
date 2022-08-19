<?php

namespace App\Http\Requests\Api\Permissions;

use App\Traits\RequestValidation\FailedValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePermissionRequest extends FormRequest
{
    use FailedValidation;

    public function rules()
    {
        return [
            'name' => 'required|max:60|unique:permissions,name',
            'details' => 'required|max:60',
            'roles' => 'required',
        ];
    }

}

