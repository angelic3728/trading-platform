<?php

namespace App\Mail\Forms;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $income_item_1;
    public $income_item_2;
    public $income_item_3;
    public $income_item_4;
    public $income_item_5;
    public $income_item_6;
    public $income_item_7;
    public $income_item_8;
    public $income_item_9;
    public $income_item_10;
    public $income_item_11;
    public $income_item_12;
    public $income_item_13;
    public $income_item_14;
    public $income_item_15;
    public $income_item_16;
    public $income_item_17;
    public $income_item_18;
    public $income_item_19;
    public $income_item_20;
    public $income_item_21;
    public $income_item_22;
    public $income_item_23;
    public $income_item_24;
    public $income_item_25;
    public $income_item_26;
    public $income_item_27;
    public $income_item_28;
    public $income_item_29;
    public $income_item_30;
    public $income_item_31;
    public $income_item_32;
    public $income_item_33;
    public $income_item_34;
    public $income_item_35;
    public $income_item_36;
    public $income_item_37;
    public $income_item_38;
    public $income_item_39;
    public $income_item_40;
    public $income_item_41;
    public $income_item_42;
    public $income_item_43;
    public $income_item_44;
    public $income_item_45;
    public $income_item_46;
    public $income_item_47;
    public $income_item_48;
    public $income_item_49;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->income_item_1 = array_get($data, 'income_item_1');
        $this->income_item_2 = array_get($data, 'income_item_2');
        $this->income_item_3 = array_get($data, 'income_item_3');
        $this->income_item_4 = array_get($data, 'income_item_4');
        $this->income_item_5 = array_get($data, 'income_item_5');
        $this->income_item_6 = array_get($data, 'income_item_6');
        $this->income_item_7 = array_get($data, 'income_item_7');
        $this->income_item_8 = array_get($data, 'income_item_8');
        $this->income_item_9 = array_get($data, 'income_item_9');
        $this->income_item_10 = array_get($data, 'income_item_10');
        $this->income_item_11 = array_get($data, 'income_item_11');
        $this->income_item_12 = array_get($data, 'income_item_12');
        $this->income_item_13 = array_get($data, 'income_item_13');
        $this->income_item_14 = array_get($data, 'income_item_14');
        $this->income_item_15 = array_get($data, 'income_item_15');
        $this->income_item_16 = array_get($data, 'income_item_16');
        $this->income_item_17 = array_get($data, 'income_item_17');
        $this->income_item_18 = array_get($data, 'income_item_18');
        $this->income_item_19 = array_get($data, 'income_item_19');
        $this->income_item_20 = array_get($data, 'income_item_20');
        $this->income_item_21 = array_get($data, 'income_item_21');
        $this->income_item_22 = array_get($data, 'income_item_22');
        $this->income_item_23 = array_get($data, 'income_item_23');
        $this->income_item_24 = array_get($data, 'income_item_24');
        $this->income_item_25 = array_get($data, 'income_item_25');
        $this->income_item_26 = array_get($data, 'income_item_26');
        $this->income_item_27 = array_get($data, 'income_item_27');
        $this->income_item_28 = array_get($data, 'income_item_28');
        $this->income_item_29 = array_get($data, 'income_item_29');
        $this->income_item_30 = array_get($data, 'income_item_30');
        $this->income_item_31 = array_get($data, 'income_item_31');
        $this->income_item_32 = array_get($data, 'income_item_32');
        $this->income_item_33 = array_get($data, 'income_item_33');
        $this->income_item_34 = array_get($data, 'income_item_34');
        $this->income_item_35 = array_get($data, 'income_item_35');
        $this->income_item_36 = array_get($data, 'income_item_36');
        $this->income_item_37 = array_get($data, 'income_item_37');
        $this->income_item_38 = array_get($data, 'income_item_38');
        $this->income_item_39 = array_get($data, 'income_item_39');
        $this->income_item_40 = array_get($data, 'income_item_40');
        $this->income_item_42 = array_get($data, 'income_item_42');
        $this->income_item_43 = array_get($data, 'income_item_43');
        $this->income_item_44 = array_get($data, 'income_item_44');
        $this->income_item_45 = array_get($data, 'income_item_45');
        $this->income_item_46 = array_get($data, 'income_item_46');
        $this->income_item_47 = array_get($data, 'income_item_47');
        $this->income_item_48 = array_get($data, 'income_item_48');
        $this->income_item_49 = array_get($data, 'income_item_49');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /**
         * Send mail
         */
        return $this->markdown('mails.forms.fixed-income')
                    ->subject("Fixed Income Form");
    }
}
