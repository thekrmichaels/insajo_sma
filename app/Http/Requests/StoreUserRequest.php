<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => ['required', 'unique:users', 'email', 'regex:/(.*)@insajo\.edu.co$/i'],
            'password' => 'required',
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
            'password' => 'contraseña',
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
            'name.required' => 'El campo :attribute es requerido',
            'email.required' => 'El campo :attribute es requerido',
            'email.unique' => 'El campo :attribute ya ha sido tomado.',
            'email.regex' => 'El campo :attribute debe tener un dominio válido.',
            'password.required' => 'El campo :attribute es requerido',
            'status.required' => 'El campo :attribute es requerido',
        ];
    }
}
