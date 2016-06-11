<?php

namespace Muhit\Http\Requests\Api;

use Muhit\Http\Requests\ApiRequest;

class Login extends ApiRequest
{

    protected $defaults = [
        'client_id' => 'required',
        'client_secret' => 'required'
    ];

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
        $required = [
            'password' => 'required',
            'email' => 'required|email',
        ];

        $required += $this->defaults;

        return $required;
    }
}
