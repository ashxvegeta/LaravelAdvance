🛠️ 1. Create the Notification
php artisan make:notification WelcomeUserNotification


🧠 2. Define Channels (Email & Database)
Open WelcomeUserNotification.php and update it like this:
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    // CHANNELS
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    // EMAIL content
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Welcome to Our App!')
                    ->greeting('Hello!')
                    ->line('Thank you for registering.')
                    ->action('Visit Our Website', url('/'))
                    ->line('We’re glad to have you with us!');
    }

    // DATABASE content
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Welcome to Our App!',
            'user_id' => $notifiable->id,
        ];
    }
}

🧑‍💻 3. Trigger Notification on User Registration
In your UserController@store, add this after user creation:

use App\Notifications\WelcomeUserNotification;

// after creating the user
$user->notify(new WelcomeUserNotification());


🛢️ 4. Set Up Database Notifications Table
php artisan notifications:table
php artisan migrate


✅ 5. Configure Mail (for email channel)

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="${APP_NAME}"
