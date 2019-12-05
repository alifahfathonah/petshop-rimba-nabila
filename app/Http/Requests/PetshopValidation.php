<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetshopValidation extends Requests
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'nm_brg' => 'required|max:255',
          'body' => 'required',
        ];
    }
    public function messages()
{
    return [
        'nm_brg.required' => 'Tolong Diisi',
        'body.required'  => 'A message is required',
    ];
}
}
