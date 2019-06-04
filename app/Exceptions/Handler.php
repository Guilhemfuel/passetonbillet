<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use function Sentry\configureScope;
use Sentry\State\Scope;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
//        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * List of exception that should not be reported by sentry
     *
     * @var array
     */
    protected $sentryDontReport = [
        PasseTonBilletException::class
    ];

    /**
     * Sentry ID of current exception
     *
     * @var
     */
    private $sentryID;


    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     *
     * @return void
     */
    public function report( Exception $exception )
    {
        if ( \App::environment() == 'production' && app()->bound( 'sentry' ) && $this->sentryShouldReport( $exception ) ) {
            if (\Auth::check()) {
                \Sentry\configureScope( function ( Scope $scope ): void {
                    $user = \Auth::user();

                    $scope->setUser( [
                        'id' => $user->id,
                        'email' => $user->email
                    ] );
                } );
            }

            $this->sentryID = app( 'sentry' )->captureException( $exception );
        }

        parent::report( $exception );
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render( $request, Exception $exception )
    {


        /*
         * PasseTonBilletException
         */
        if ( $exception instanceof PasseTonBilletException) {

            if ($request->expectsJson()) {
                return response([
                    'status' => 'error',
                    'message' => $exception->getMessage()
                ],500);
            } else {
                flash()->error($exception->getMessage());
                return \Redirect::back()->withInput( $request->input() )->with( 'ptb_error', $exception->getMessage() );
            }
        }

        /*
         * Sentry Debug
         */
        if ( \App::environment() == 'production' && app()->bound( 'sentry' ) && $this->sentryShouldReport( $exception ) ) {
            return response()->view( 'errors.500', [
                'sentryID' => $this->sentryID,
            ], 500 );

        }

        /*
         * Debug whoops
         */
        elseif ( config( 'app.debug' ) && app()->environment() != 'production' ) {
            return $this->handleWhoopsies( $request, $exception );
        }

        return parent::render( $request, $exception );

    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request                 $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated( $request, AuthenticationException $exception )
    {
        if ( $request->expectsJson() ) {
            return response()->json( [ 'error' => 'Unauthenticated.' ], 401 );
        }

        return redirect()->guest( 'login' );
    }

    /**
     * Returns true if exception should be reported by Sentry
     *
     * @param $exception
     *
     * @return bool
     */
    protected function sentryShouldReport( $exception )
    {
        if ( \App::environment() != 'production' ) {
            return false;
        }

        foreach ( $this->sentryDontReport as $exceptionClass ) {
            if ( $exception instanceof $exceptionClass ) {
                return false;
            }
        }

        return $this->shouldReport( $exception );
    }

    /**
     * @param           $request
     * @param Exception $exception
     *
     * @return \Illuminate\Http\Response|mixed
     */
    protected function handleWhoopsies( $request, Exception $exception )
    {

        if ( $request->ajax() || $request->expectsJson() ) {
            return $this->renderJsonExceptionWithWhoops($exception);
        } else {
            return $this->renderExceptionWithWhoops( $exception );
        }
    }

    /**
     * @return mixed
     */
    protected function renderJsonExceptionWithWhoops(Exception $exception)
    {
        $whoops = new \Whoops\Run;
        $handler = new \Whoops\Handler\JsonResponseHandler;
        $whoops->pushHandler( $handler );

        return new \Illuminate\Http\Response(
            $whoops->handleException( $exception ),
            $exception->getStatusCode(),
            $exception->getHeaders()
        );
    }

    /**
     * Render an exception using Whoops.
     *
     * @param  \Exception $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function renderExceptionWithWhoops( Exception $exception )
    {
        $whoops = new \Whoops\Run;
        $handler = new \Whoops\Handler\PrettyPageHandler();
        $handler->setEditor( config( 'app.editor' ) );
        $whoops->pushHandler( $handler );

        if ($exception instanceof ValidationException) {
            $handler->addDataTable('Validation Errors',$exception->validator->getMessageBag()->toArray());
        }

        return new \Illuminate\Http\Response(
            $whoops->handleException( $exception ),
            $exception->getStatusCode(),
            $exception->getHeaders()
        );
    }

}
