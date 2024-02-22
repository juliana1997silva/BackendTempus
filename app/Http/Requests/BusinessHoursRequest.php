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
        $rules =
            [
                'date'                               => 'required|string',
                'location'                           => 'required|string',
                'user_id'                            => 'required|string',
                'entry_time'                         => 'required|string',
                'lunch_entry_time'                   => 'required|string',
                'lunch_out_time'                     => 'required|string',
                'out_time'                           => 'required|string',
                'status'                             => 'string',
                'nonbusiness'                        => array([
                    'id'                                 => 'string',
                    'registry_id'                        => 'string',
                    'entry_time'                         => 'required|string',
                    'lunch_entry_time'                   => 'string',
                    'lunch_out_time'                     => 'string',
                    'out_time'                           => 'required|string',
                ]),
                'consults'                           => array([
                    'id'            => 'string',
                    'registry_id'   => 'string',
                    'queries'       => 'required|string',
                    'description'   => 'required|string'
                ])
            ];

        if ($this->method() === "PUT") {
            $rulesDate['date'] = [
                'string',
                "unique:business_hours,date,{$this->id},id"
            ];

            $rules = [
                    'date'                               => $rulesDate['date'],
                    'location'                           => 'string',
                    'user_id'                            => 'string',
                    'entry_time'                         => 'string',
                    'lunch_entry_time'                   => 'string',
                    'lunch_out_time'                     => 'string',
                    'out_time'                           => 'string',
                ];
        }

        if ($this->method() === "PATCH") {
            $rules = [
                'date'                               => 'string',
                'location'                           => 'string',
                'user_id'                            => 'string',
                'entry_time'                         => 'string',
                'lunch_entry_time'                   => 'string',
                'lunch_out_time'                     => 'string',
                'out_time'                           => 'string',
                'status'                             => 'required|string',
                'nonbusiness'                        => array([
                    'id'                                 => 'string',
                    'registry_id'                        => 'string',
                    'entry_time'                         => 'string',
                    'lunch_entry_time'                   => 'string',
                    'lunch_out_time'                     => 'string',
                    'out_time'                           => 'string',
                ]),
                'consults'                           => array([
                    'id'            => 'string',
                    'registry_id'   => 'string',
                    'queries'       => 'string',
                    'description'   => 'string'
                ])
            ];
        }

        return  $rules;
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
            'nonbusiness'           => $this->nonbusiness,
            'consults'              => $this->consults,
            'status'                => $this->status,
           
        ];
    }
}
