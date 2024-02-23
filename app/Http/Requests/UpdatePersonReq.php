<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonReq extends FormRequest
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
            'firstname' => ['required', 'min:5', 'max:30'],
            'lastname' => ['required', 'max:50', 'min:5'],
            'phonenumber' => ['min:6', 'numeric'],
            'born' => ['required', 'date'],
            'email' => ['required', 'min:6', 'email'],
            'sex' => [Rule::in(['male', 'famale'])],
            'person_type_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pesel' => ['numeric'],
        ];
    }

    public function messages()
    {
        return [
            'lastname.required' => 'Nie podano nazwiska',
            'firstname.required' => 'Nie podano imienia',
            'email.required' => 'Nie podano emaila',
            'born.required' => 'Nie podano datu urodzenia',
            'person_type_id.reqired' => "Nie podano typu osoby",
            'city_id.reqired' => "Nie podano Typu miasta",
            'firstname.max' => 'Maksymalna ilość znaków to: :max',
            'lastname.max' => 'Maksymalna ilość znaków to: :max',
            'pesel.numeric' => 'Podana wawtosc nie jest peselem'
        ];
    }
}
