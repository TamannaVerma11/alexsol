<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInviteRequest extends FormRequest
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
            'name'       => 'required|string|max:100',
            'email'      => 'required|email:rfc,dns|unique:users,email|max:255',
            'phone'      => 'required|string|min:7|max:30|unique:users,phone',
            'company_id' => 'required',
        ];
    }
}
