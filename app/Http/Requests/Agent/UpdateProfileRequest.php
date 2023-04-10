<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone_number' => 'nullable|max:11|min:11|string|unique:clients,phone_number',
            'profile_picture' => 'nullable',
            'account_number' => 'nullable|string|max:10|min:10',
            'bank_name' => 'nullable|string',
            'home_address' => 'nullable|string',
        ];
    }
}