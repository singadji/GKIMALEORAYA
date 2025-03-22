<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use RealRashid\SweetAlert\Facades\Alert;

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

    public function render($request, Throwable $exception)
    {
    if ($exception instanceof TokenMismatchException) {
    // Jika terjadi TokenMismatchException, alihkan ke halaman /home
    Alert::warning('Sesi Kedaluwarsa', 'Anda akan dialihkan ke halaman utama.');
    return redirect('/home');
    }
    return parent::render($request, $exception);
    }

}
