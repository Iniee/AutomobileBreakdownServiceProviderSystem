<?php

namespace App\Http\Requests\Client;

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
          'first_name' => 'required|string|max:50',
          'last_name' => 'required|string|max:50',
          'user_name' => 'required|unique:users,user_name|string',
          'email' => 'required|email|unique:users,email|string',
          'home_address' => 'required|string',
          'phone_number' => 'required|max:11|min:11|string|unique:users,phone_number',
          'gender' => 'required|in:male,female',
          'password' => ['required', 'string', 'confirmed', 'min:8' ]
        ];

        
    }
}