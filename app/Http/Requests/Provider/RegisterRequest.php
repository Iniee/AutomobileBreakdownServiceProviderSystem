<?php

namespace App\Http\Requests\Provider;

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
            'email' => 'string|max:50|unique:users,email',
            'phone_number' => 'required|string|max:11|min:11|unique:service_provider,phone_number',
            'business_address' => 'required|string',
            'gender' => 'required|in:male,female',
            'type' => 'required|string|in:Artisan,Cab Driver,Tow Truck',
            'account_number' => 'string|min:10|max:10',
            'bank_name' => 'string',
            'profile_picture' => 'required',
            'password' => ['required', 'string', 'confirmed', 'min:8' ]
        ];
    }
}