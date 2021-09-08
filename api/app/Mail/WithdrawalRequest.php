<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class WithdrawalRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $date;
    public $amount;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $timezone, $amount)
    {
        $this->user = $user;
        $this->date = Carbon::now()->copy()->tz($timezone)->format('F j, Y h:i A');
        $this->amount = $amount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->subject('Withdrawal Request')->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'))->view('email.withdrawalrequest');
    }
}
