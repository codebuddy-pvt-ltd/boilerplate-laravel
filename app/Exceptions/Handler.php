<?php

namespace App\Exceptions;

use Throwable;
use App\Services\Http\Response\APIResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
    }

    public function render($request, Throwable $th)
    {
        if ($request->ajax() && $th instanceof ValidationException) {
            return APIResponse::build()
                ->errors($th->errors())
                ->status('error')
                ->statusCode(422)
                ->send();
        } elseif ($request->ajax()) {
            return APIResponse::sendInternalServerError($th);
        }
    }
}
