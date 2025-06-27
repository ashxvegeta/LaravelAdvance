🧱 1. Create Middleware
php artisan make:middleware TrackUserActivity


 2. Define Middleware Logic
app/Http/Middleware/TrackUserActivity.php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('User visited: ' . $request->fullUrl());

        return $next($request);
    }
}

Final web group might look like:

'web' => [
    \App\Http\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \App\Http\Middleware\VerifyCsrfToken::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
    \App\Http\Middleware\TrackUserActivity::class,
],

4. Test It

Route::get('/test', function () {
    return 'You hit the test route!';
});


Then check your logs:
storage/logs/laravel.log

