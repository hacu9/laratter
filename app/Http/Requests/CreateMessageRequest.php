<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMessageRequest extends FormRequest
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
        'message' => 'required|min:20|max:120'
        ];
    }
    public function messages(){
        return [
        'message.required' => 'Por favor, escribe tu mensaje',
        'message.max' => 'El mensaje debe tener menos de 120 caracteres',
        'message.min' => 'El mensaje debe tener mas de 20 caracteres',
        ];
    }
}
