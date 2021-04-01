<?php

namespace App\Exceptions;

use Log;
use Auth;

use Throwable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported. ie. that will not be logged
     *
     * @var array
     */
    protected $dontReport = [
        ////
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
                    Log::warning($exception->getMessage(), ['user_id' => isset(Auth::user()->id) ? Auth::user()->id : '' ]);
                    break;
                case "Illuminate\Database\Eloquent\ModelNotFoundException":
                    Log::warning($exception->getMessage(), ['user_id' => isset(Auth::user()->id) ? Auth::user()->id : '']);
                    break;
                case "Illuminate\Session\TokenMismatchException":
                    Log::notice($exception->getMessage(), ['user_id' => isset(Auth::user()->id) ? Auth::user()->id : '']);
                    break;
                case "Symfony\Component\HttpKernel\Exception\NotFoundHttpException":
                    Log::notice($exception->getMessage(), ['user_id' => isset(Auth::user()->id) ? Auth::user()->id : '']);
                    break;
                case "Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException":
                    Log::error($exception->getMessage(), ['user_id' => isset(Auth::user()->id) ? Auth::user()->id : '']);
                    break;
                case "Symfony\Component\HttpKernel\Exception\HttpExceptionInterface":
                    Log::warning($exception->getMessage(), ['user_id' => isset(Auth::user()->id) ? Auth::user()->id : '']);
                    break;
                case "Symfony\Component\Debug\Exception\FatalErrorException":
                    Log::critical($exception->getMessage(), ['user_id' => isset(Auth::user()->id) ? Auth::user()->id : '']);
                    break;
                case "Exception":

                    Log::error($exception, ['user_id' => isset(Auth::user()->id) ? Auth::user()->id : '']);
                    break;
                case "App\Exceptions\GeneralException":  //CUSTOM EXCEPTION

                    Log::error("Exception Message: " . $exception->getMessage() . "--" . " File: " . $exception->getFile() . "--" . " Line: " . $exception->getLine() . "--" . $exception->getPrevious() , ['user_id' => isset(Auth::user()->id) ? Auth::user()->id : '']);

                default:

            }



            if($this->isHttpException($exception)){
                //dd($exception->getStatusCode());
                switch ($exception->getStatusCode()) {
                    case '404':
                         return $this->renderHttpException($exception);
                    break;
                    case '500':
                        return $this->renderHttpException($exception);
                    break;
                    default:
                        return $this->renderHttpException($exception);
                    break;
                }
            }else{
                return parent::render($request, $exception);
            }


        return parent::render($request, $exception);
    }



    /**
     * Override default method.
     * To have separate error page for admin and public area.
     */
    protected function renderHttpException(HttpExceptionInterface $e)
    {

        $status = $e->getStatusCode();

        list($subdomain) = explode('.', \Request::getHost(), 2);

        if ($subdomain != 'www') {
            URL::defaults(['clientSubdomain' => $subdomain]);
            $viewName = "frontend.errors.".$status;
        } else {
            $viewName = "admin.errors.".$status;
            URL::defaults(['clientSubdomain' => 'www']);
        }


        if (view()->exists($viewName)) {
            return response()->view($viewName, ['exception' => $e], $status, $e->getHeaders());
        } else {
            return $this->convertExceptionToResponse($e);
        }
    }

    /**
     * Determine what view to show based on route
     *
     * @param int $status
     * @return string
     */
    protected function getViewName($status)
    {
        if (request()->is('admin/*')) {
            return "admin.errors.{$status}";
        }

        return "frontend.errors.{$status}";
    }
}
