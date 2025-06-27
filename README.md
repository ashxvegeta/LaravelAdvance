Create the middleware:

php artisan make:middleware AdminMiddleware

Inside app/Http/Middleware/AdminMiddleware.php:

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        abort(403, 'You do not have admin access.');
    }
}
Register in app/Http/Kernel.php under $routeMiddleware:

protected $routeMiddleware = [
    // ...
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];


 Use in route:

 Route::get('/admin/dashboard', function () {
    return 'Welcome Admin!';
})->middleware(['auth', 'admin']);
