<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGroupsRequest extends FormRequest
{
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
            'group_id' => 'required|string',
            'user_id' => 'required|array'
        ];
    }


    public function handle()
    {
        return [
            'group_id' => $this->group_id,
            'user_id' => $this->user_id
        ];
    }
}
