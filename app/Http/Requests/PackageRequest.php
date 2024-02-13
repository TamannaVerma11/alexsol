<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
            'name.*'      => 'required|string|max:255',
            'price'       => 'required|numeric',
            'user'        => 'required|integer',
            'size_min'    => 'required|integer',
            'size_max'    => 'required|integer',
            'details.*'   => 'required|string|max:65535',
        ];
    }

}
