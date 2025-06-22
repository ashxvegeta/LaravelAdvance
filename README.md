✅ Step 1: Update your User model
Make sure your users table has a role column (admin / user) and remove SoftDeletes if not needed.


namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}




✅ Step 2: Login Blade Form (resources/views/login.blade.php)
<h1>Login</h1>

<form method="POST" action="{{ route('loginsubmit') }}">
    @csrf
    <p>Name</p>
    <input type="text" name="name" required>

    <p>Email</p>
    <input type="email" name="email" required>

    <button type="submit">Login</button>
</form>


✅ Step 3: Login Logic in Controller


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

public function loginsubmit(Request $request)
{
    $email = $request->input('email');
    $name = $request->input('name');

    $user = User::where('email', $email)
                ->where('name', $name)
                ->first();

    if ($user) {
        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/dashboard');
        }
    }

    return back()->withErrors(['Invalid credentials']);
}

✅ Step 4: Middleware for Admin Access

php artisan make:middleware AdminMiddleware


// app/Http/Middleware/AdminMiddleware.php
Then edit the file:
public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }

    abort(403, 'Unauthorized access.');
}

Register it in app/Http/Kernel.php:
'admin' => \App\Http\Middleware\AdminMiddleware::class,


✅ Step 5: Define Routes in web.php


use App\Http\Controllers\UserController;

Route::get('/login', function () {
    return view('login');
});
Route::post('/loginsubmit', [UserController::class, 'loginsubmit'])->name('loginsubmit');

Route::get('/admin/dashboard', function () {
    return 'Welcome to admin Dashboard';
})->middleware(['auth', 'admin']);

Route::get('/dashboard', function () {
    return 'Welcome to user Dashboard';
})->middleware('auth');

Testing
Try logging in with an admin email → should redirect to /admin/dashboard

Try logging in with a user email → should redirect to /dashboard

Try accessing /admin/dashboard without logging in or as user → should give 403
