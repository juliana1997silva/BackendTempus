<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class EventsRequest extends FormRequest
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
            'user_id'               => 'string',
            'title'                 => 'required|string',
            'start'                 => 'required|string',
            'end'                   => 'required|string',
            'backgroundColor'       => 'string',
            'allDay'                => 'boolean'
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
            
            'title.required'    => "Titulo é Obrigatorio",
            'start.required'    => "Data Inicial Obrigatorio",
            'end.required'      => "Data Final Obrigatorio"
            
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
            'id'                    => $this->id,
            'user_id'               => $this->user_id,
            'title'                 => $this->title,
            'start'                 => $this->start,
            'end'                   => $this->end,
            'backgroundColor'       => $this->backgroundColor,
            'allDay'                => $this->allDay,
        ];
    }
}
