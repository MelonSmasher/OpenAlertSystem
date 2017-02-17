<?php

namespace App\Http\Controllers;

use App\Model\Email;
use App\Model\MobilePhone;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\SMS\Facades\SMS;
use Snowfire\Beautymail\Beautymail;

class AlertBuilderController extends Controller
{
    public function index()
    {

        return view('builder');
    }

    public function dispatchAlert(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();
        $subject = $data['subject'];
        $message = $data['message'];
        $method = $data['method'];
        $authorized = true;

        // Verify permissions based on the dispatch method
        /*        switch ($method) {
                    case 'both':
                        if ($user->can(['send-email', 'send-sms'], true)) {
                            $authorized = true;
                        }
                        break;
                    case 'mobile':
                        if ($user->can('send-sms', true)) {
                            $authorized = true;
                        }
                        break;
                    case 'email':
                        if ($user->can('send-email', true)) {
                            $authorized = true;
                        }
                        break;
                    default:
                        $request->session()->flash('alert-danger', 'Alert method not recognized!');
                        return redirect()->route('index');
                }*/

        // If we aren't authorized return back
        if (!$authorized) {
            $request->session()->flash('alert-danger', 'You are not authorized to perform that operation!');
            return redirect()->route('index');
        }

        // Get all users with their emails and mobile phones
        $users = User::with('emails', 'mobilePhones.carrier')->get();

        // Build the mail class
        $beautymail = app()->make(Beautymail::class);
        $from_address = env('MAIL_FROM_ADDRESS', 'alert@domain.tld');

        // Build the sms message
        $sms_mesage = 'Subject: ' . $subject . "\n" . $message;

        // Go over all users
        foreach ($users as $user) {
            if ($method === 'mobile' || $method === 'both') {
                foreach ($user->mobilePhones as $item) {
                    SMS::queue($sms_mesage, [], function ($sms) use ($item) {
                        if (env('SMS_DRIVER', 'email') === 'email') {
                            $sms->to('+1' . $item->number, $item->carrier->code);
                        } else {
                            $sms->to('+1' . $item->number);
                        }
                    });
                }
            }
            if ($method === 'email' || $method === 'both') {
                // Send the message to their authentication email
                $this->sendAlertEmail($beautymail, $message, $subject, $user->name, $from_address, $user->email);
                // Send the message to each of their aditional emails
                foreach ($user->emails as $item) {
                    $this->sendAlertEmail($beautymail, $message, $subject, $user->name, $from_address, $item->address);
                }

            }
        }
        $request->session()->flash('alert-success', 'Message have been dispatched to the queue.');
        return redirect()->route('index');
    }

    /**
     * @param Beautymail $beautymail
     * @param $message
     * @param $subject
     * @param $user_name
     * @param $from_address
     * @param $to_address
     */
    public function sendAlertEmail(Beautymail $beautymail, $message, $subject, $user_name, $from_address, $to_address)
    {
        $beautymail->queue('emails.alert', ['alert' => $message, 'subject' => $subject],
            function ($message) use ($user_name, $from_address, $to_address, $subject) {
                $message
                    ->from($from_address)
                    ->to($to_address, $user_name)
                    ->subject($subject);
            });
    }
}
