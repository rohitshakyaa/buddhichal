<?php

namespace App\Exceptions;

use App\Http\Helpers\ApiResponseHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*') or $request->expectsJson()) {
            if ($e instanceof AuthenticationException) {
                return ApiResponseHelper::unauthorizedResponse("Unauthenticated");
            }

            if ($e instanceof NotFoundHttpException) {
                return ApiResponseHelper::notFoundResponse();
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return ApiResponseHelper::methodNotAllowedResponse();
            }

            if ($e instanceof ValidationException) {
                Log::error($e->errors());
                return ApiResponseHelper::validationErrorResponse($e->errors());
            }
        }

        return parent::render($request, $e);
    }
}
