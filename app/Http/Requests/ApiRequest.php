<?php

namespace Muhit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use ResponseService;

abstract class ApiRequest extends FormRequest
{

    public function response(array $errors)
    {
        if ($this->ajax() || $this->wantsJson()) {

            \Log::info('Error occurred:' . json_encode($errors));
            
            return new JsonResponse($errors, 422);
        }

        return response()->api(200, 'ValidationError', $errors);
    }
}
