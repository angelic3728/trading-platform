<?php

namespace App\Mail\Forms;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $acc_item_1;
    public $acc_item_2;
    public $acc_item_3;
    public $acc_item_4;
    public $acc_item_5;
    public $acc_item_6;
    public $acc_item_7;
    public $acc_item_8;
    public $acc_item_9;
    public $acc_item_10;
    public $acc_item_11;
    public $acc_item_12;
    public $acc_item_13;
    public $acc_item_14;
    public $acc_item_15;
    public $acc_item_16;
    public $acc_item_17;
    public $acc_item_18;
    public $acc_item_19;
    public $acc_item_20;
    public $acc_item_21;
    public $acc_item_22;
    public $acc_item_23;
    public $acc_item_24;
    public $acc_item_25;
    public $acc_item_26;
    public $acc_item_27;
    public $acc_item_28;
    public $acc_item_29;
    public $acc_item_30;
    public $acc_item_31;
    public $acc_item_32;
    public $acc_item_33;
    public $acc_item_35;
    public $acc_item_36;
    public $acc_item_37;
    public $acc_item_38;
    public $acc_item_39;
    public $acc_item_40;
    public $acc_item_42;
    public $acc_item_43;
    public $acc_item_44;
    public $acc_item_45;
    public $acc_item_46;
    public $acc_item_47;
    public $acc_item_48;
    public $acc_item_49;
    public $acc_item_50;
    public $acc_item_51;
    public $acc_item_52;
    public $acc_item_53;
    public $acc_item_54;
    public $acc_item_55;
    public $acc_item_56;
    public $acc_item_57;
    public $acc_item_58;
    public $acc_item_59;
    public $acc_item_60;
    public $acc_item_61;
    public $acc_item_62;
    public $acc_item_63;
    public $acc_item_64;
    public $acc_item_65;
    public $acc_item_66;
    public $acc_item_67;
    public $acc_item_68;
    public $acc_item_73;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->acc_item_1 = array_get($data, 'acc_item_1');
        $this->acc_item_2 = array_get($data, 'acc_item_2');
        $this->acc_item_3 = array_get($data, 'acc_item_3');
        $this->acc_item_4 = array_get($data, 'acc_item_4');
        $this->acc_item_5 = array_get($data, 'acc_item_5');
        $this->acc_item_6 = array_get($data, 'acc_item_6');
        $this->acc_item_7 = array_get($data, 'acc_item_7');
        $this->acc_item_8 = array_get($data, 'acc_item_8');
        $this->acc_item_9 = array_get($data, 'acc_item_9');
        $this->acc_item_10 = array_get($data, 'acc_item_10');
        $this->acc_item_11 = array_get($data, 'acc_item_11');
        $this->acc_item_12 = array_get($data, 'acc_item_12');
        $this->acc_item_13 = array_get($data, 'acc_item_13');
        $this->acc_item_14 = array_get($data, 'acc_item_14');
        $this->acc_item_15 = array_get($data, 'acc_item_15');
        $this->acc_item_16 = array_get($data, 'acc_item_16');
        $this->acc_item_17 = array_get($data, 'acc_item_17');
        $this->acc_item_18 = array_get($data, 'acc_item_18');
        $this->acc_item_19 = array_get($data, 'acc_item_19');
        $this->acc_item_20 = array_get($data, 'acc_item_20');
        $this->acc_item_21 = array_get($data, 'acc_item_21');
        $this->acc_item_22 = array_get($data, 'acc_item_22');
        $this->acc_item_23 = array_get($data, 'acc_item_23');
        $this->acc_item_24 = array_get($data, 'acc_item_24');
        $this->acc_item_25 = array_get($data, 'acc_item_25');
        $this->acc_item_26 = array_get($data, 'acc_item_26');
        $this->acc_item_27 = array_get($data, 'acc_item_27');
        $this->acc_item_28 = array_get($data, 'acc_item_28');
        $this->acc_item_29 = array_get($data, 'acc_item_29');
        $this->acc_item_30 = array_get($data, 'acc_item_30');
        $this->acc_item_31 = array_get($data, 'acc_item_31');
        $this->acc_item_32 = array_get($data, 'acc_item_32');
        $this->acc_item_33 = array_get($data, 'acc_item_33');
        $this->acc_item_35 = array_get($data, 'acc_item_35');
        $this->acc_item_36 = array_get($data, 'acc_item_36');
        $this->acc_item_37 = array_get($data, 'acc_item_37');
        $this->acc_item_38 = array_get($data, 'acc_item_38');
        $this->acc_item_39 = array_get($data, 'acc_item_39');
        $this->acc_item_40 = array_get($data, 'acc_item_40');
        $this->acc_item_42 = array_get($data, 'acc_item_42');
        $this->acc_item_43 = array_get($data, 'acc_item_43');
        $this->acc_item_44 = array_get($data, 'acc_item_44');
        $this->acc_item_45 = array_get($data, 'acc_item_45');
        $this->acc_item_46 = array_get($data, 'acc_item_46');
        $this->acc_item_47 = array_get($data, 'acc_item_47');
        $this->acc_item_48 = array_get($data, 'acc_item_48');
        $this->acc_item_49 = array_get($data, 'acc_item_49');
        $this->acc_item_50 = array_get($data, 'acc_item_50');
        $this->acc_item_51 = array_get($data, 'acc_item_51');
        $this->acc_item_52 = array_get($data, 'acc_item_52');
        $this->acc_item_53 = array_get($data, 'acc_item_53');
        $this->acc_item_54 = array_get($data, 'acc_item_54');
        $this->acc_item_55 = array_get($data, 'acc_item_55');
        $this->acc_item_56 = array_get($data, 'acc_item_56');
        $this->acc_item_57 = array_get($data, 'acc_item_57');
        $this->acc_item_58 = array_get($data, 'acc_item_58');
        $this->acc_item_59 = array_get($data, 'acc_item_59');
        $this->acc_item_60 = array_get($data, 'acc_item_60');
        $this->acc_item_61 = array_get($data, 'acc_item_61');
        $this->acc_item_62 = array_get($data, 'acc_item_62');
        $this->acc_item_63 = array_get($data, 'acc_item_63');
        $this->acc_item_64 = array_get($data, 'acc_item_64');
        $this->acc_item_65 = array_get($data, 'acc_item_65');
        $this->acc_item_66 = array_get($data, 'acc_item_66');
        $this->acc_item_67 = array_get($data, 'acc_item_67');
        $this->acc_item_68 = array_get($data, 'acc_item_68');
        $this->acc_item_73 = array_get($data, 'acc_item_73');
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
        return $this->markdown('mails.forms.new-account')
                    ->subject("New Account Open Request");
    }
}
