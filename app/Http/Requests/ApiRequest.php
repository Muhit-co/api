<?php

namespace Muhit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use ResponseService;

abstract class ApiRequest extends FormRequest
{

    protected $defaults = [
        'user_id' => 'required|numeric|min:1',
        'api_token' => 'required|min:1'
    ];

    public function response(array $errors)
    {
        if ($this->ajax() || $this->wantsJson()) {

            \Log::info('Error occurred:' . json_encode($errors));
            
            return new JsonResponse($errors, 422);
        }

        return ResponseService::createValidationErrors($errors);
    }
}
