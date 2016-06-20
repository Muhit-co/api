<?php

namespace Muhit\Http\Requests\Api;

use Muhit\Http\Requests\ApiRequest;

class CreateIssue extends ApiRequest
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
            'user_id' => 'required|numeric|min:1',
            'title' => 'required|min:5',
            'desc' => 'required|min:20',
            'location' => 'required',
            'tags' => 'required',
            'coordinates' => 'required|min:5',
            'is_anonymous' => 'required'
        ];

        $required += $this->defaults;

        return $required;
    }
}
