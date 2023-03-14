<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
          'name' => 'required|string|max:50',
          'phone_number' => 'string|max:11,min:10',
          'gender' => 'required|in:male,female',
          'password' => ['required', 'string', 'confirmed', 'min:8' ],
          'email' => 'required|email|unique:users,email|string',
          'account_number' => 'string|max:10,min:10',
          'bank_name' => 'string',
        ];
    }
}