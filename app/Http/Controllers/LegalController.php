<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function imprint() {
        return view('legal.imprint');
    }

    public function termsofservice() {
        return view('legal.terms-of-service');
    }

    public function privacy() {
        return view('legal.privacy-policy');
    }
}
