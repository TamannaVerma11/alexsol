<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email:rfc,dns|unique:users,email,' . $user . '|max:255',
            'report_content'        => 'nullable|string|max:65535',
            'upload_company_img'    => 'nullable',
            'payment_cycle'         => 'required',
            'password'              => 'nullable|string|min:5|confirmed',
        ];
    }
}
