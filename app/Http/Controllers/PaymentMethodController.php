<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        // Get payment links from footer data for bank logos
        $paymentLinks = \App\Models\FooterLink::where('column_title', 'PEMBAYARAN')
            ->where('label', '!=', 'Qris')
            ->orderBy('order')
            ->get();

        return view('payment-methods.index', [
            'paymentLinks' => $paymentLinks
        ]);
    }
}
