<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->route('home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
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
