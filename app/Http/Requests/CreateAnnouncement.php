<?php

namespace Muhit\Http\Requests;

class CreateAnnouncement extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hood_id' => 'required|min:1',
            'location' => 'required',
            'title' => 'required|min:5',
            'content' => 'required|min:20',
        ];
    }
}
