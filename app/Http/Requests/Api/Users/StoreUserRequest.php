<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\BaseFormRequest;

class StoreUserRequest extends BaseFormRequest
{
    /**
     * Nome que será retornado caso de erro de validação
     */
    protected $modelName = 'Usuário';
    protected $validationAction = 'adicionar';

    public function prepareForValidation()
    {
        $this->merge([
            'password' => bcrypt('12345678')
        ]);
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ];
    }
}
