<?php

namespace App\Http\Requests\Api\Roles;

use App\Traits\RequestValidation\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest  extends FormRequest
{
    use FailedValidation;

    public function rules()
    {
        return [
            'name' => 'required|max:60|unique:roles,name',
            'details' => 'required|max:60',
            'permissions' => 'required'
        ];
    }
}
