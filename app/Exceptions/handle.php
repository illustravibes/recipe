<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'success' => false,
                    'errors' => $exception->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], $this->getStatusCode($exception));
        }

        return parent::render($request, $exception);
    }

    protected function getStatusCode(Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return Response::HTTP_NOT_FOUND;
        }

        return $exception->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}