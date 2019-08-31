<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Mail\BaseMailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserResetPasswordMail extends BaseMailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $forgot_password_code)
    {
        parent::__construct();
        $this->user = $user;
        $this->forgot_password_code = $forgot_password_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Forgot password')
            ->view('emails.forgot_password')
            ->with([
                'user' => $this->user,
                'forgot_password_code' => $this->forgot_password_code,
            ]);
    }
}
