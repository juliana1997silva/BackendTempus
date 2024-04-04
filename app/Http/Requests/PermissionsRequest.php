<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PermissionsRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'string'
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
            
            'name.required' => "Nome Obrigatorio",         
        ];
    }

    public function handle()
    {

        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }
}
