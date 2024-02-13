<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'name.*'          => 'required|string|max:255',
            'tips_yes.*'      => 'nullable|string',
            'tips_no.*'       => 'nullable|string',
            'option1.*'       => 'nullable|string|max:65535',
            'option2.*'       => 'nullable|string|max:65535',
            'option3.*'       => 'nullable|string|max:65535',
            'option4.*'       => 'nullable|string|max:65535',
            'option5.*'       => 'nullable|string|max:65535',
            'option6.*'       => 'nullable|string|max:65535',
        ];
    }

}
