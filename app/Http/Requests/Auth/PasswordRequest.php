<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

class PasswordRequest extends FormRequest
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
            'old_password' => 'required|min:6',
            'new_password' =>'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password'
           
        ];
    }
    public function messages()
        {
            return [
                'old_password.required' => 'Old password is required',
                'old_password.min' => 'Minimum password length is 6',
                'confirm_password.min' => 'Minimum password length is 6',
                'new_password.min' => 'Minimum password length is 6',
                'confirm_password.same' => 'Password invalid',
                'old_password.same' => 'Password invalid',
                'new_password.same' => 'Password invalid',
                'new_password.required' => 'New password is required',
                'confirm_password.required' => 'Confirm password is required',
                
            ];
        }
}
