<?php

namespace Muhit\Services;

class ResponseService
{
    public function createSuccessMessage($code)
    {
        $message = $this->getMessageFromCode($code);

        $response = [
            'meta' => 'true',
            'code' => 200,
            'content' => [
                'message' => $message,
            ]
        ];

        return response()->json($response);
    }

    public function getMessageFromCode($code)
    {
        return trans('response-messages.' . $code);
    }

    public function createErrorMessage($type)
    {
        $message = $this->getMessageFromCode($type);

        $response = [
            'meta' => 'false',
            'code' => 900,
            'content' => [
                'message' => $message
            ]
        ];

        return response()->json($response, 401);
    }

    public function createValidationErrors($errorBag, $type = 'requestValidation')
    {
        $message = $this->getMessageFromCode($type);

        $response = [
            'meta' => 'false',
            'code' => 900,
            'content' => [
                'message' => $message
            ],
            'errors' => $errorBag
        ];

        return response()->json($response, 401);
    }

    public function createResponse($key, $value)
    {
        $response = [
            'meta' => 'true',
            'code' => 200,
            'content' => [
                $key => $value
            ]
        ];

        return response()->json($response);
    }

    public function createMultiple($keys = array())
    {
        $list = [];

        if (is_array($keys)) {

            foreach ($keys as $key => $value) {

                if ($key == 'message') {

                    $value = $this->getMessageFromCode($value);
                }

                $list[$key] = $value;
            }
        }

        $response = [
            'meta' => 'true',
            'code' => 200,
            'content' => $list
        ];

        return response()->json($response);
    }

    public function createInvalidParameter($type, $list)
    {
        $message = $this->getMessageFromCode($type);

        $response = [
            'meta' => 'false',
            'code' => 400,
            'content' => [
                'message' => $message,
                'parameters' => $list
            ]
        ];

        return response()->json($response, 401);
    }
}