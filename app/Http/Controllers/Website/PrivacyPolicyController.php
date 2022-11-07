<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrivacyPolicyController extends Controller
{
    public function index(Request $request) {
        return view('privacy-policy.' . app()->getLocale());
    }
}
