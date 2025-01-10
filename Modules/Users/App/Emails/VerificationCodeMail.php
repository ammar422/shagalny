<?php

namespace Modules\Users\App\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param object $user
     * @param integer $code
     */
    public function __construct(
        public $user,
        public $code
    ) {}

    /**
     * Build the message.
     * @return self
     */
    public function build(): self
    {
        return $this->subject('Email Verification Code')
            ->view('users::emails.plain_verification_code')
            ->with([
                'code' => $this->code,
            ]);
    }
}
