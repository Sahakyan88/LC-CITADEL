<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

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
     * @return array
     */
    public function rules()
    {
        
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'last_name' => 'required',
            'first_name' => 'required',
            'phone' => 'required|string',
        ];
    }
    public function messages()
        {
            return [
                'email.required' => 'Email is required',
                'email.unique' => 'Email already exists',
                'password.required' => 'Password is required',
                'password.min' => 'Minimum password length is 6',
                'last_name.required' => 'Last name is required',
                'first_name.required' => 'First name is required',
                'phone.required' => 'Phone number is required',
            ];
        }
}
