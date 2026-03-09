<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(8);
            
        return view('karir.index', compact('jobs'));
    }
}
