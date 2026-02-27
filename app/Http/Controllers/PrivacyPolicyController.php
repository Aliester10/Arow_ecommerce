<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $privacyPolicy = PrivacyPolicy::getActive();
        
        // If no active policy exists, show a default message
        if (!$privacyPolicy) {
            return view('privacy-policy-empty');
        }
        
        return view('kebijakan-privasi', compact('privacyPolicy'));
    }
}
