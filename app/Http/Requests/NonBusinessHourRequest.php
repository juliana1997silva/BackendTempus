<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class NonBusinessHourRequest extends FormRequest
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
            'entry_time'                         => 'required|string',
            'lunch_entry_time'                   => 'string',
            'lunch_out_time'                     => 'string',
            'out_time'                           => 'required|string',
            'observation'                        => 'required|string'
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
            'entry_time.required'           => "Horario de Entrada Obrigatorio",
            'out_time.required'             => "Horario da Saída Obrigatorio",
            'observation.required'          => "Observação Obrigatória"
        ];
    }

    public function handle()
    {
        return [
            'entry_time'            => $this->entry_time,
            'lunch_entry_time'      => $this->lunch_entry_time,
            'lunch_out_time'        => $this->lunch_out_time,
            'out_time'              => $this->out_time,
            'observation'           => $this->observation,
           
        ];
    }
}
