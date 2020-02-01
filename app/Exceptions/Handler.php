<?php

namespace App\Exceptions;

use App\Traits\Responsive;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use UnexpectedValueException;

class Handler extends ExceptionHandler
{
    use Responsive;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [ //
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
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request    $request
     * @param \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $isApiRequest = $request->is("api/*") || $request->wantsJson();
        if ($isApiRequest) {
            $this->dontReport = array_merge($this->dontReport, [
                HttpException::class,
                OAuthServerException::class,
                UnexpectedValueException::class,
                UnauthorizedException::class,
                AuthenticationException::class,
                AuthorizationException::class,
                MethodNotAllowedHttpException::class,
                NotFoundHttpException::class,
                ModelNotFoundException::class,
                FileNotFoundException::class,
                ValidationException::class,
            ]);
            return $this->handle($request, $exception);
        }
        return parent::render($request, $exception);
    }

    /**
     * @param Request   $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function handle(Request $request, Exception $e)
    {
        Log::info("Exception: " . $e->getMessage());

        if ($e instanceOf ApplicationException) {
            return $this->error('HamraaException');
        }

        if ($e instanceOf NotFoundHttpException) {
            return $this->notFound();
        }

        if ($e instanceOf HttpException || $e instanceof AuthenticationException) {
            return $this->notAuthorized();
        }


        if ($e instanceOf UnauthorizedException) {
            return $this->notAuthorized();
        }

        if ($e instanceOf OAuthServerException) {
            return $this->notAuthenticated();
        }

        if ($e instanceOf UnexpectedValueException) {
            return $this->error();
        }

        if ($e instanceOf FileNotFoundException) {
            return $this->notFound('FileNotFound');
        }

        if ($e instanceOf ModelNotFoundException) {
            return $this->notFound('ModelNotFound');
        }

        if ($e instanceOf MethodNotAllowedHttpException) {
            return $this->notAllowed();
        }

        if ($e instanceOf AuthorizationException) {
            return $this->notAuthorized();
        }

        if ($e instanceOf ValidationException) {
            return $this->notValid($e);
        }

        return $this->error('InternalError', 500, [
            'general' => [
                trans('messages.internal_error'),
                $e->getMessage(),
                get_class($e) . ' in ' . $e->getFile() . ' on line ' . $e->getLine(),
                // $e->getTraceAsString()
            ]
        ]);
    }
}
