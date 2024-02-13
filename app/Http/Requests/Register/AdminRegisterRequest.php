<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class AdminRegisterRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
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
            'name'       => 'required|string|max:100',
            'email'      => 'required|email:rfc,dns|unique:admins,email|max:255',
            'profile'    => 'nullable|image|mimes:jpg,png,jpeg|max:10000',
            'phone'      => 'required|string|min:7|max:30|unique:admins,phone',
            'password'   => 'required|string|min:5|confirmed',
        ];
    }
}
