<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $user = request()->input('user');
        return [
            'name'       => 'nullable|string|max:100',
            'email'      => 'required|email:rfc,dns|unique:users,email,' . $user . '|max:255',
            'profile'    => 'nullable|image|mimes:jpg,png,jpeg|max:10000',
            'phone'      => 'nullable|string|min:7|max:30|unique:users,phone',
        ];
    }

}
