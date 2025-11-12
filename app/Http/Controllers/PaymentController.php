<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\Bank;
use App\Models\Currency;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request){
        /**
         * validate request like:
         * card number 16 digits
         * cvv 3 digits
         * card expire 4 digits
         * check card's holder name validity
         * validate amount
         */

        /**
         * check merchant validation and get merchant information
         */

        /**
         * with card information and currency information you have to decide which pos you should make payment
         * and get that pos information
         */

        /**
         * from pos information you will get bank id
         * and get bank information
         */

        /**
         * from bank information
         * you have bank url
         * you have bank username
         * you have bank password
         * you have bank branch
         * you have bank code
         */

        /**
         * now you have to prepare a request and sent to bank
         * and bank will provide success and failed response
         * based on response you have to insert that transaction in our system
         */



    }
}
