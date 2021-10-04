<?php

namespace App\Notifications;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class userPasswordResetNotification extends Notification implements ShouldQueue
{

    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    public $subdomain;
   // public $emailTo;

    /**
     * The callback that should be used to create the reset password URL.
     *
     * @var \Closure|null
     */
    public static $createUrlCallback;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token, $subdomain)//, $emailTo
    {
        $this->token = $token;
        $this->subdomain = $subdomain;
        //$this->emailTo = filter_var( $emailTo, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }


    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = url(route('frontend.password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
                //'email' => $this->emailTo,
                'clientSubdomain' => $this->subdomain
            ], false));
        }

        $url = str_replace("//www." , "//".$this->subdomain.".", $url);

        $details['email_title'] = config('app.name')." Reset Password Notification";
        $details['reset_url'] = $url;
        $details['password_expiry_time'] = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        return (new MailMessage)->cc([$notifiable->personal_email])->subject(Lang::get('Reset Password Notification'))->view('frontend.auth.mail.reset-password', ['details' => $details]);

    }

    /**
     * Set a callback that should be used when creating the reset password button URL.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
