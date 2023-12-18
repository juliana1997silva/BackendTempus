<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CoordinatorRequest extends FormRequest
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
            'name' => 'required|string',
            'group_id' => 'required|string',
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
            'group_id.required' => "Id do Grupo Obrigatorio",
        ];
    }

    public function handle()
    {
        return [
            'name' => $this->name,
            'group_id' => $this->group_id,  
        ];
    }
}
