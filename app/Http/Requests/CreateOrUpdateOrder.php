<?php

namespace App\Http\Requests;

class CreateOrUpdateOrder extends BaseRequest
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
            'user_fname' => 'string|required|max:255',
            'user_lname' => 'string|required|max:255',
            'user_phone' => 'string|required|max:15',
            'zip_code' => 'string|required|max:12',
            'user_address' => 'string|required',
            'total' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'quantity' => 'integer|required'
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
            'user_fname' => 'trim|escape|strip_tags',
            'user_lname' => 'trim|escape|strip_tags',
            'user_phone' => 'trim|escape|strip_tags',
            'zip_code' => 'trim|escape|strip_tags',
            'user_address' => 'trim|escape|strip_tags',
            'total' => 'trim|escape|strip_tags',
            'quantity' => 'trim|escape|strip_tags'
        ];
    }
}
