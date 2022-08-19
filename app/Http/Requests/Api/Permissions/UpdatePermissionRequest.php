<?php

namespace App\Http\Requests\Api\Permissions;

use App\Traits\RequestValidation\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest  extends FormRequest
{
    use FailedValidation;

    public function rules()
    {
        return [
            'name' => "required|max:60|unique:permissions,name,{$this->id}",
            'details' => 'required|max:60',
            'roles' => 'required',
        ];
    }

}

