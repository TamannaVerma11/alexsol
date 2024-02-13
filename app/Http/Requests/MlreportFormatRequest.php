<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MlreportFormatRequest extends FormRequest
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
            'report_title.*'      => 'required|string|min:3|max:255',
            'report_desc.*'       => 'required|string|min:3|max:65535',
            'report_image.*'      => 'required',
        ];
    }

}
