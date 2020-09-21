<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use App\Exceptions\GeneralException;
use Auth;

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
        //
    }


        /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        
            //gets the exception class 
            $exception_type = get_class($exception);

            switch ($exception_type) {
                case "Illuminate\Auth\Access\AuthorizationException":
                    Log::warning($exception->getMessage(), ['user_id' => Auth::user()->id]);
                    break;
                case "Illuminate\Database\Eloquent\ModelNotFoundException":
                    Log::warning($exception->getMessage(), ['user_id' => Auth::user()->id]);
                    break;
                case "Illuminate\Session\TokenMismatchException":
                    Log::notice($exception->getMessage(), ['user_id' => Auth::user()->id]);
                    break;
                case "Symfony\Component\HttpKernel\Exception\NotFoundHttpException":
                    Log::notice($exception->getMessage(), ['user_id' => Auth::user()->id]);
                    break;
                case "Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException":
                    Log::error($exception->getMessage(), ['user_id' => Auth::user()->id]);
                    break;
                case "Symfony\Component\HttpKernel\Exception\HttpExceptionInterface":
                    Log::warning($exception->getMessage(), ['user_id' => Auth::user()->id]);
                    break;
                case "Symfony\Component\Debug\Exception\FatalErrorException":
                    Log::critical($exception->getMessage(), ['user_id' => Auth::user()->id]);
                    break;
                case "Exception":
                    Log::error($exception, ['user_id' => Auth::user()->id]);
                    break;
                case "App\Exceptions\GeneralException":  //CUSTOM EXCEPTION
                
                    Log::error("Exception Message: " . $exception->getMessage() . "--" . " File: " . $exception->getFile() . "--" . " Line: " . $exception->getLine() . "--" . $exception->getPrevious() , ['user_id' => Auth::user()->id]);

                default:

            }      

        return parent::render($request, $exception);
    }

}
