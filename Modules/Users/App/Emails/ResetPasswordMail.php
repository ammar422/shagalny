<?php

namespace Modules\Users\App\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Users\App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     * @param User $user
     */
    public function __construct(
        public User $user
    ) {}

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject(__('users::auth.reset_password_mail'))
            ->view('users::emails.plain_password_code')
            ->with([
                'code' => $this->user->reset_token,
                'name' => $this->user->name,
            ]);
    }
}
