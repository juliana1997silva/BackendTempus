<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
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
            'queries' => 'required|string',
            'description' => 'required|string'
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
            
            'queries.required' => "Numero da Consulta Obrigatorio",
            'description.required' => "Descrição da Consulta Obrigatorio",
            
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
            'queries'           => $this->queries,
            'description'       => $this->description
        ];
    }
}
