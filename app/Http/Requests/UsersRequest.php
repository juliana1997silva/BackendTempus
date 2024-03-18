<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
        $rules =  [
            //
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255 | unique:users',
            'team_id' => 'string',
            'entry_time' => 'required|string|max:255',
            'lunch_entry_time' => 'required|string|max:255',
            'lunch_out_time' => 'required|string|max:255',
            'out_time' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'admin' => 'integer',
            'manager' => 'integer',
            'user_interpres_code' => 'string'
        ];

        if ($this->method() === "PUT") {
            $rules = [
                'name' => 'string|max:255',
                'phone' => 'string|max:255',
                'email' => 'string|email|max:255',
                'team_id' => 'string',
                'entry_time' => 'string|max:255',
                'lunch_entry_time' => 'string|max:255',
                'lunch_out_time' => 'string|max:255',
                'out_time' => 'string|max:255',
                'password' => 'string|min:8',
                'admin' => 'integer',
                'manager' => 'integer',
                'user_interpres_code' => 'string'
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
            'email.unique' => "E-mail já cadastrado !",
            'name.required' => "Nome Obrigatorio",
            'email.required' => "E-mail Obrigatorio",
            'phone.required' => "Telefone Obrigatorio",
            'entry_time.required' => "Horário de Entrada Obrigatorio",
            'lunch_entry_time.required' => "Inicio do Almoço/Janta Obrigatorio",
            'lunch_out_time.required' => "Termino do Almoço/Janta Obrigatorio",
            'out_time.required' => "Horario da Saída Obrigatorio",
            'password.required' => "Senha Obrigatorio"

        ];
    }

    public function handle()
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'team_id' => $this->team_id,
            'entry_time' => $this->entry_time,
            'lunch_entry_time' => $this->lunch_entry_time,
            'lunch_out_time' => $this->lunch_out_time,
            'out_time' => $this->out_time,
            'password' => $this->password,
            'admin' => isset($this->admin) ? $this->admin : 0,
            'manager' => $this->manager,
            'status' => isset($this->status) ? $this->status : 1,
            'user_interpres_code' => $this->user_interpres_code
        ];
    }
}
