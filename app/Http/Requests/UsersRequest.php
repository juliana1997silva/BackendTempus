<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        return [
            //
            'name' => 'required|string|max:255',
            /* 'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255 | unique:users',
            'coordinator_id' => 'required',
            'entry_time' => 'required|string|max:255',
            'lunch_entry_time' => 'required|string|max:255',
            'lunch_out_time' => 'required|string|max:255',
            'out_time' => 'required|string|max:255',
            'password' => 'required|string|min:8'  */
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
           // 'email.unique' => "E-mail já cadastrado !"
           'name.required' => "Nome Obrigatorio"
        ];
    }

    public function handle()
    {
        $this->request->all();
        return [
            'name' => $this->name,
            //'phone' => $this->phone
        ];
    }
}
