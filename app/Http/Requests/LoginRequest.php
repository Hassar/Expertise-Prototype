<?php

namespace App\Http\Requests;

class LoginRequest extends BaseRequest
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
            'email' => 'string|required|max:20|exists:users,email',
            'password' => 'string|required|between:6,20',
            'device_name' => 'string|required|in:spa,mobile_app'
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'email' => 'trim|escape|strip_tags',
            'password' => 'trim|escape|strip_tags',
            'device_name' => 'trim|escape|strip_tags'
        ];
    }
}
