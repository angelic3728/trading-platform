<?php

namespace App\Mail\Trade\Confirmation;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class User extends Mailable
{
    use Queueable, SerializesModels;

    public $action;
    public $user;
    public $stock;
    public $price;
    public $institutional_price;
    public $shares;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->action = array_get($data, 'action');
        $this->user = array_get($data, 'user');
        $this->stock = array_get($data, 'stock');
        $this->price = array_get($data, 'price');
        $this->institutional_price = array_get($data, 'institutional_price');
        $this->shares = array_get($data, 'shares');
        $this->date = array_get($data, 'date');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        /**
         * Prepare Subject
         */
        if($this->action == 'buy'){

            $subject = 'Trade Confirmation: You have bought '.$this->shares.' shares of '.$this->stock->symbol.' stock';

        } else {

            $subject = 'Trade Confirmation: You have sold '.$this->shares.' shares of '.$this->stock->symbol.' stock';

        }

        /**
         * Send mail
         */
        return $this->markdown('mails.trade.confirmation.user')
                    ->subject($subject);
    }
}
