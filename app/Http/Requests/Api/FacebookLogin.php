<?php

namespace Muhit\Http\Requests\Api;

use Muhit\Http\Requests\ApiRequest;

class FacebookLogin extends ApiRequest
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
            'access_token'
        ];

        $required += $this->defaults;

        return $required;
    }
}
