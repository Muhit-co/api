<?php

namespace Muhit\Http\Requests\Api;

use Muhit\Http\Requests\ApiRequest;

class UpdateUserInfo extends ApiRequest
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
        $required = [
            'username' => 'required|min:3',
            'email' => 'required|email',
            'first_name' => 'required|min:1',
            'last_name' => 'required|min:1',
        ];

        $required += $this->defaults;

        return $required;
    }
}
