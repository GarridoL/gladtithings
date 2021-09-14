<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
class Receipts extends Mailable
{
    use Queueable, SerializesModels;
    public $user = array(
        'email' => 'test@gmail.com'
    );
    public $date = 'July 8, 2021 5:00 PM';
    public $dataReceipt = array(
        'receipt_number' => 12345,
        'title' => 'Church 1',
        'amount' => 'USD 50, 000',
        'date' => 'July 8, 2021 5:00 PM',
        'method' => [
          'stripe' => [
            'last4' => 1234
          ],
          'paypal' => [
            'email' => 'testemail@gmail.com'
          ]
        ]
      );


    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct($user, $data, $timezone)
    // {
    //     $this->user = $user;
    //     $this->dataReceipt = $data;
    //     // echo json_encode($data);
    //     $this->date = Carbon::now()->copy()->tz($timezone)->format('F j, Y h:i A');
    // }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->subject('Transaction Receipt')->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'))->view('email.receipts');
    }
}
