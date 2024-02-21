<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ExpensesRequest extends FormRequest
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
            'km'                    => 'string',
            'coffe'                 => 'string',
            'lunch'                 => 'string',
            'dinner'                => 'string',
            'parking'               => 'string',
            'toll'                  => 'string',
            'others'                => 'string',
            'total'                 => 'string'
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
            
           // 'title.required'    => "Titulo é Obrigatorio",
            //'start.required'    => "Data Inicial Obrigatorio",
            //'end.required'      => "Data Final Obrigatorio"
            
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
            'km'                    => $this->km,
            'coffe'                 => $this->coffe,
            'lunch'                 => $this->lunch,
            'dinner'                => $this->dinner,
            'parking'               => $this->parking,
            'toll'                  => $this->toll,
            'others'                => $this->others,
            'total'                 => $this->total,
        ];
    }
}
