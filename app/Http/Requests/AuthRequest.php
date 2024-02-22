<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{

    // protected $forceJsonResponse = true;
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
            //
            'email' => 'required|string',
            'password' => 'required|string',
            'confirmation_password' => 'string',
            'new_password' => 'string'
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

            'email.required' => "E-mail Obrigatório",
            'password.required' => "Senha Obrigatório",

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function handle()
    {
        return [
            'email'                         => $this->email,
            'password'                      => $this->password,
            'confirmation_password'         => $this->confirmation_password,
            'new_password'                  => $this->new_password
        ];
    }
}
