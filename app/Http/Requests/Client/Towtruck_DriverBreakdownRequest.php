<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class Towtruck_DriverBreakdownRequest extends FormRequest
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
            'breakdown_location' => 'required|string',
            'destination_location'=>'string',
        ];
    }
}