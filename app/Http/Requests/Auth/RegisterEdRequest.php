<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

class RegisterEdRequest extends FormRequest
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
            'last_name' => 'required',
            'first_name' => 'required',
            'phone' => 'required|numeric',

        ];
    }
    public function messages()
        {
            return [
                'last_name.required' => 'Last name is required',
                'first_name.required' => 'First name is required',
                'phone.numeric' => 'The value should be a number',
                'phone.required' => 'Phone number is required',
            ];
        }
}
