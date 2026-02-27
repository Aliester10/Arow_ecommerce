<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        $faqs = Faq::active()->ordered()->get();
        return view('bantuan.index', compact('faqs'));
    }
}
