<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /* front homepage view */
    public function index($langcode)
    {
        return view('front.user.faqs.faq');
    }

}
