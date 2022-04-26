<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

use App\Http\Controllers\API\StockController;
use App\Http\Controllers\API\FundsController;
use App\Http\Controllers\API\BondsController;
use App\Http\Controllers\API\CryptosController;

class FormsController extends Controller
{

    public function index()
    {

        // Get all highlights
        $stock_highlights = StockController::highlights(4)->getData();
        $fund_highlights = FundsController::highlights(4)->getData();
        $bond_highlights = BondsController::highlights(4)->getData();
        $crypto_highlights = CryptosController::highlights(4)->getData();

        $all_highlights = array_merge($stock_highlights->data, $fund_highlights->data);
        $all_highlights = array_merge($all_highlights, $bond_highlights->data);
        $all_highlights = array_merge($all_highlights, $crypto_highlights->data);

        /**
         * Return view
         */
        return view('forms.main', [
            'all_highlights' => $all_highlights,
        ]);
    }

    public function equities()
    {
        return view('forms.equities');
    }

    public function account_form(Request $request)
    {

        $data = [
            'acc_item_1' => $request->acc_item_1,
            'acc_item_2' => $request->acc_item_2,
            'acc_item_3' => $request->acc_item_3,
            'acc_item_4' => $request->acc_item_4,
            'acc_item_5' => $request->acc_item_5,
            'acc_item_6' => $request->acc_item_6,
            'acc_item_7' => $request->acc_item_7,
            'acc_item_8' => $request->acc_item_8,
            'acc_item_9' => $request->acc_item_9,
            'acc_item_10' => $request->acc_item_10,
            'acc_item_11' => $request->acc_item_11,
            'acc_item_12' => $request->acc_item_12,
            'acc_item_13' => $request->acc_item_13,
            'acc_item_14' => $request->acc_item_14,
            'acc_item_15' => $request->acc_item_15,
            'acc_item_16' => $request->acc_item_16,
            'acc_item_17' => $request->acc_item_17,
            'acc_item_18' => $request->acc_item_18,
            'acc_item_19' => $request->acc_item_19,
            'acc_item_20' => $request->acc_item_20,
            'acc_item_21' => $request->acc_item_21,
            'acc_item_22' => $request->acc_item_22,
            'acc_item_23' => $request->acc_item_23,
            'acc_item_24' => $request->acc_item_24,
            'acc_item_25' => $request->acc_item_25,
            'acc_item_26' => $request->acc_item_26,
            'acc_item_27' => $request->acc_item_27,
            'acc_item_28' => $request->acc_item_28,
            'acc_item_29' => $request->acc_item_29,
            'acc_item_30' => $request->acc_item_30,
            'acc_item_31' => $request->acc_item_31,
            'acc_item_32' => $request->acc_item_32,
            'acc_item_33' => $request->acc_item_33,
            'acc_item_35' => $request->acc_item_35,
            'acc_item_36' => $request->acc_item_36,
            'acc_item_37' => $request->acc_item_37,
            'acc_item_38' => $request->acc_item_38,
            'acc_item_39' => $request->acc_item_39,
            'acc_item_40' => $request->acc_item_40,
            'acc_item_42' => $request->acc_item_42,
            'acc_item_43' => $request->acc_item_43,
            'acc_item_44' => $request->acc_item_44,
            'acc_item_45' => $request->acc_item_45,
            'acc_item_46' => $request->acc_item_46,
            'acc_item_47' => $request->acc_item_47,
            'acc_item_48' => $request->acc_item_48,
            'acc_item_49' => $request->acc_item_49,
            'acc_item_50' => $request->acc_item_50,
            'acc_item_51' => $request->acc_item_51,
            'acc_item_52' => $request->acc_item_52,
            'acc_item_53' => $request->acc_item_53,
            'acc_item_54' => $request->acc_item_54,
            'acc_item_55' => $request->acc_item_55,
            'acc_item_56' => $request->acc_item_56,
            'acc_item_57' => $request->acc_item_57,
            'acc_item_58' => $request->acc_item_58,
            'acc_item_59' => $request->acc_item_59,
            'acc_item_60' => $request->acc_item_60,
            'acc_item_61' => $request->acc_item_61,
            'acc_item_62' => $request->acc_item_62,
            'acc_item_63' => $request->acc_item_63,
            'acc_item_64' => $request->acc_item_64,
            'acc_item_65' => $request->acc_item_65,
            'acc_item_66' => $request->acc_item_66,
            'acc_item_67' => $request->acc_item_67,
            'acc_item_68' => $request->acc_item_68,
            'acc_item_73' => $request->acc_item_73,
        ];

        Mail::to(config('app.email'))->send(new \App\Mail\Forms\NewAccount($data));

        return back()->with('success', 'Thanks for contacting me, I will get back to you soon!');
    }

    public function fixed_income()
    {
        return view('forms.fixed_income');
    }

    public function application_form(Request $request)
    {

        $data = [
            'income_item_1' => $request->income_item_1,
            'income_item_2' => $request->income_item_2,
            'income_item_3' => $request->income_item_3,
            'income_item_4' => $request->income_item_4,
            'income_item_5' => $request->income_item_5,
            'income_item_6' => $request->income_item_6,
            'income_item_7' => $request->income_item_7,
            'income_item_8' => $request->income_item_8,
            'income_item_9' => $request->income_item_9,
            'income_item_10' => $request->income_item_10,
            'income_item_11' => $request->income_item_11,
            'income_item_12' => $request->income_item_12,
            'income_item_13' => $request->income_item_13,
            'income_item_14' => $request->income_item_14,
            'income_item_15' => $request->income_item_15,
            'income_item_16' => $request->income_item_16,
            'income_item_17' => $request->income_item_17,
            'income_item_18' => $request->income_item_18,
            'income_item_19' => $request->income_item_19,
            'income_item_20' => $request->income_item_20,
            'income_item_21' => $request->income_item_21,
            'income_item_22' => $request->income_item_22,
            'income_item_23' => $request->income_item_23,
            'income_item_24' => $request->income_item_24,
            'income_item_25' => $request->income_item_25,
            'income_item_26' => $request->income_item_26,
            'income_item_27' => $request->income_item_27,
            'income_item_28' => $request->income_item_28,
            'income_item_29' => $request->income_item_29,
            'income_item_30' => $request->income_item_30,
            'income_item_31' => $request->income_item_31,
            'income_item_32' => $request->income_item_32,
            'income_item_33' => $request->income_item_33,
            'income_item_34' => $request->income_item_34,
            'income_item_35' => $request->income_item_35,
            'income_item_36' => $request->income_item_36,
            'income_item_37' => $request->income_item_37,
            'income_item_38' => $request->income_item_38,
            'income_item_39' => $request->income_item_39,
            'income_item_40' => $request->income_item_40,
            'income_item_41' => $request->income_item_41,
            'income_item_42' => $request->income_item_42,
            'income_item_43' => $request->income_item_43,
            'income_item_44' => $request->income_item_44,
            'income_item_45' => $request->income_item_45,
            'income_item_46' => $request->income_item_46,
            'income_item_47' => $request->income_item_47,
            'income_item_48' => $request->income_item_48,
            'income_item_49' => $request->income_item_49,
        ];

        Mail::to(config('app.email'))->send(new \App\Mail\Forms\FixedIncome($data));

        return back()->with('success', 'Thanks for contacting me, I will get back to you soon!');
    }
}
