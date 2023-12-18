<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class BusinessHoursRequest extends FormRequest
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
            'date'                               => 'required|string|unique:business_hours,date',
            'location'                           => 'required|string',
            'user_id'                            => 'required|string',
            'entry_time'                         => 'required|string',
            'lunch_entry_time'                   => 'required|string',
            'lunch_out_time'                     => 'required|string',
            'out_time'                           => 'required|string',
            'observation'                        => 'string',
            'nonbusiness'                       => array([
                'entry_time'                         => 'required|string',
                'lunch_entry_time'                   => 'string',
                'lunch_out_time'                     => 'string',
                'out_time'                           => 'required|string',
            ]),
            'consults'                           => array([
                'queries'       => 'required|string',
                'description'   => 'required|string'
            ])
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
            'date.required'                 => "Data Obrigatorio",
            'date.unique'                   => "Data já registrada",
            'location.required'             => "Local Obrigatorio",
            'user_id.required'              => "Id Usuario Obrigatorio",
            'entry_time.required'           => "Horario de Entrada Obrigatorio",
            'lunch_entry_time.required'     => "Inicio do Almoço/Janta Obrigatorio",
            'lunch_out_time.required'       => "Termino do Almoço/Janta Obrigatorio",
            'out_time.required'             => "Horario da Saída Obrigatorio"
            
        ];
    }

    public function handle()
    {
        return [
            'date'                  => $this->date,
            'location'              => $this->location,
            'user_id'               => $this->user_id,
            'entry_time'            => $this->entry_time,
            'lunch_entry_time'      => $this->lunch_entry_time,
            'lunch_out_time'        => $this->lunch_out_time,
            'out_time'              => $this->out_time,
            'observation'           => $this->observation,
            'nonbusiness'           => $this->nonbusiness,
            'consults'              => $this->consults
        ];
    }
}
