<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $emails = $user->emails;
        $phones_raw = $user->mobilePhones;
        $phones = [];

        foreach ($phones_raw as $p) {
            $p->number_formatted = formatPhoneNumber($p->number, $p->country_code);
            $phones[] = $p;
        }

        return view('home', [
            'user' => $user,
            'phones' => $phones,
            'emails' => $emails,
            'auth_email' => $user->email
        ]);
    }
}
