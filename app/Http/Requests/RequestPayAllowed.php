<?php

namespace App\Http\Requests;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

class RequestPayAllowed extends FormRequest
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
         
            'pay_allowed' =>'required'

        ];
    }
    public function messages()
        {
            return [
                
                'pay_allowed.required' => 'Please confirm that you have read the terms of the contract',
            ];
        }
}
