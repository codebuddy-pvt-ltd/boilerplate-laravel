<?php

namespace App\Exceptions;

use Throwable;
use App\Services\Http\Response\APIResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $th) {
            $isAjax = request()->ajax() || isRequestForAPI();

            if ($isAjax && $th instanceof ValidationException) {
                return APIResponse::build()
                    ->errors($th->errors())
                    ->status('error')
                    ->statusCode(422)
                    ->send();
            } elseif ($isAjax && $th instanceof NotFoundHttpException) {
                return APIResponse::build()
                    ->status('error')
                    ->statusCode(404)
                    ->message('Resource not found!')
                    ->send();
            } elseif ($isAjax) {
                return APIResponse::sendInternalServerError($th);
            }
        });
    }
}
