<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($this->user), 'regex:/^[a-zA-Z0-9]+@insajo\.edu\.co$/'],
            'status' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'status' => 'estado',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El :attribute es requerido',
            'email.required' => 'El :attribute es requerido',
            'email.unique' => 'El :attribute ya ha sido tomado.',
            'email.regex' => 'El :attribute debe tener caracteres alfanuméricos y un dominio válido.',
            'status.required' => 'El :attribute es requerido',
        ];
    }
}
