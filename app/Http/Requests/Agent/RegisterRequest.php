<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
          'email' => 'required|email|unique:users,email|string',
          'phone_number' => 'required|max:11|min:11|string|unique:agents,phone_number',
          'home_address' => 'required|string',
          'gender' => 'required|in:male,female',
          'profile_picture' => 'required',
          'password' => ['required', 'string', 'confirmed', 'min:8' ],
        ];
    }
}