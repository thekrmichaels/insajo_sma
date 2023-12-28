<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
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
            'teacher_id' => 'required',
            'status' => 'required',
            'name' => 'required',
            'description' => 'required',
            'since' => 'required|date_format:Y-m-d H:i:s|after_or_equal:today',
            'deadline' => 'required|date_format:Y-m-d H:i:s|after:since',
            'homework' => 'required',
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
            'teacher_id' => 'clase',
            'status' => 'estado',
            'name' => 'nombre de la actividad',
            'description' => 'descripción de la actividad',
            'since' => 'fecha de inicio',
            'deadline' => 'fecha límite',
            'homework' => 'material de la actividad',
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
            'teacher_id.required' => 'El campo :attribute es requerido',
            'status.required' => 'El campo :attribute es requerido',
            'name.required' => 'El campo :attribute es requerido',
            'description.required' => 'El campo :attribute es requerido',
            'since.required' => 'El campo :attribute es requerido',
            'since.after_or_equal' => 'La :attribute debe ser mayor o igual a hoy',
            'deadline.after' => 'La :attribute debe ser mayor a la fecha de inicio',
            'deadline.required' => 'El campo :attribute es requerido',
            'homework.required' => 'El campo :attribute es requerido',
        ];
    }
}
