<?php

namespace App\Http\Requests\Api\Roles;

use App\Traits\RequestValidation\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest  extends FormRequest
{
    use FailedValidation;

    public function rules()
    {
        return [
            'details' => 'required|max:60',
            'permissions' => 'required'
        ];
    }
}

