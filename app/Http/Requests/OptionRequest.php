<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
            'support_email'  => 'nullable|email:rfc,dns|min:3|max:255',
            'support_phone'  => 'nullable|string|min:7|max:30',
            'support_address'=> 'nullable|string|min:3|max:255',
        ];
    }

}
