<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefundCashierController extends Controller
{
    //
    public function display(){
        return view('cashier.refund');
    }
}
