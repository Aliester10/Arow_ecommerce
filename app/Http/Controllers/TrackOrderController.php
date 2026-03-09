<?php

namespace App\Http\Controllers;

use App\Models\FooterLink;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    public function index()
    {
        // Fetch delivery services from footer_links table where column_title = "PENGIRIMAN"
        $deliveryServices = FooterLink::where('column_title', 'PENGIRIMAN')
            ->orderBy('order', 'asc')
            ->get();

        return view('lacak-pesanan.index', compact('deliveryServices'));
    }
}
