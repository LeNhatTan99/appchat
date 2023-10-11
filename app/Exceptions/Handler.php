<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

/**
    * Check if we are trying to access /admin any URL preceded by admin
    *  Redirect the user to the appropriate login page.
    * @return void
    */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
       
        if ($request->is('admin') || $request->is('admin/*')) {
            return redirect()->guest('/admin');
        }
        
        return redirect()->guest(route('login'));
    }

      /**
     * @param \Illuminate\Http\Request $request
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            return $this->renderErrorApi($request, $e);
        }
        return parent::render($request, $e);
    }
   /**
     * @param $request
     * @param $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function renderErrorApi($request, $exception)
    {
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        $msg = 'Server Error';
        $response = [
            'code' => $statusCode,
            'msg' => $msg
        ];
        if ($exception instanceof AuthenticationException)
        {
            $statusCode = Response::HTTP_UNAUTHORIZED;
            $response = [
                'code' => Response::HTTP_UNAUTHORIZED,
                'msg' => 'Unauthenticated',
            ];
        }

        if ($exception instanceof ValidationException)
        {
            $msg =  'Unauthenticated';
            $flagError = 0;
            // foreach ($exception->errors() as $field => $errors) {
            //     foreach ($errors as $key => $value) {
            //         $msg = $value;
            //         $flagError++;
            //         continue;
            //     }
            //     if($flagError > 1) {
            //         break;
            //     }
            // }
            // $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            // $response = [
            //     'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            //     'errors' => $errors,
            // ];
            $errors = [];
            foreach ($exception->errors() as $field => $fieldErrors) {
                $errors[$field] = $fieldErrors;
            }
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $response = [
                'code' => $statusCode,
                'errors' => $errors,
            ];
        }

        if (
            $exception instanceof ModelNotFoundException ||
            $exception instanceof NotFoundHttpException ||
            $exception instanceof MethodNotAllowedHttpException
        )
        {
            $statusCode = Response::HTTP_NOT_FOUND;
            $msg = 'Not Found';
            $response = [
                'code' => Response::HTTP_NOT_FOUND,
                'msg' => $msg,
            ];
        }
        return response()->json($response, $statusCode);
    }
}
