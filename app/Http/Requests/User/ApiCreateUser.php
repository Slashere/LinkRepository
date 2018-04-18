<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ApiCreateUser extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'required|string|max:255|min:3',
            'name' => 'required|string|max:255|min:2',
            'last_name' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ];
    }

}
