<?php

namespace App\Traits;

use Illuminate\Validation\ValidationException;

trait Responsive
{
    use CamelCaseable;

    public function notAuthenticated($message = 'Unauthenticated')
    {
        return $this->error($message, 401, [
            'general' => [trans('messages.unauthenticated')]
        ]);
    }

    public function notAuthorized($message = 'Unauthorized')
    {
        return $this->error($message, 403, [
            'general' => [trans('messages.unauthorized')]
        ]);
    }

    public function notFound($message = 'NotFound')
    {
        return $this->error($message, 404, [
            'general' => [trans('messages.not_found')]
        ]);
    }

    public function notAllowed($message = 'NotAllowed')
    {
        return $this->error($message, 405, [
            'general' => [trans('messages.not_allowed')]
        ]);
    }

    /**
     * @param ValidationException $e
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function notValid($e, $message = 'NotValid')
    {
        return $this->error($message, 422, array_merge(
            [
                'general' => [trans('messages.not_valid')]
            ],
            $e->errors()
        ));
    }

    public function internalError($message = 'InternalError')
    {
        return $this->error($message, 500, [
            'general' => [trans('messages.internal_error')]
        ]);
    }

    public function error($message = 'BadRequest', $statusCode = 400, $errors = [])
    {
        if (empty($errors)) {
            if ($message === 'UnknownError') {
                $data = ['general' => [trans('messages.unknown_error')]];
            } else {
                $data = ['general' => [trans('messages.bad_request')]];
            }
        } else {
            $data = $errors;
        }

        return $this->respond(['errors' => $data], $message, $statusCode, 'fail');
    }

    public function respond(
        $data = [],
        $message = '',
        $statusCode = 200,
        $status = 'ok',
        $headers = [],
        $options = 0
    )
    {
        return response()->json(array_merge(
            ['meta' => [
                'status' => $status,
                'message' => $message,
                'statusCode' => $statusCode,
            ]],
            $this->toCamelCase($data)
        ), $statusCode, $headers, $options);
    }

}
