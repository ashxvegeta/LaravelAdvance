1. Create a Job
php artisan make:job SendWelcomeEmail


 2. Implement Logic in the Job

 Inside your SendWelcomeEmail job:

use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

public function handle()
{
    Mail::to($this->user->email)->send(new WelcomeEmail($this->user));
}


3. Dispatch the Job

SendWelcomeEmail::dispatch($user);
You likely did this inside your Event Listener like:


public function handle(UserRegistered $event)
{
    SendWelcomeEmail::dispatch($event->user);
}

4. Set Up Queue Driver
   
QUEUE_CONNECTION=database
php artisan queue:table
php artisan migrate


5. Run the Queue Worker
php artisan queue:work


6. Optional: Monitor the Queue

php artisan queue:work --tries=3 --timeout=60
