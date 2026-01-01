<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use App\Models\LookupType;
use App\Models\LookupValue;
use Carbon\Carbon;

if (!function_exists('getTrx')) {
    function getTrx($type = 'all',$length = 12)
    {
        switch ($type) {
            case 'all':
                $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
                break;
            case 'letters':
                $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                break;
            case 'numeric':
                $characters = '1234567890';
                break;
            
            default:
                $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
                break;
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('saasDomain')) {
    function saasDomain()
    {
        return 'main';
    }
}

if (!function_exists('routeExists')) {
    function routeExists($route)
    {
        if (Route::has($route)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('formatted_date')) {
    function formatted_date()
    {
        return 'd M Y';
    }
}

if(!function_exists('lov_lookup')){
    function lov_lookup($id){
        $type = LookupType::with('values')->find($id);
        return $type;
    }
}

if(!function_exists('lookup_with_type')){
    function lookup_with_type($id){
        $type = LookupType::with('values')->where('lookup_code',$id)->first();
        return $type;
    }
}

if(!function_exists('lookup_value')){
    function lookup_value($id){
        $value = LookupValue::with('type')->find($id);
        if(!$value){
            return '';
        }
        return $value->lookup_name;
    }
}

if (!function_exists('sendMail')) {
    function sendMail($send_to_name, $send_to_email, $subject, $body)
    {
        try {
            $mail_val = [
                'send_to_name' => $send_to_name,
                'send_to' => $send_to_email,
                'email_from' => env('MAIL_FROM_ADDRESS'),
                'email_from_name' => env('MAIL_FROM_NAME'),
                'subject' => $subject,
            ];
            Mail::send('email.mail', ['body' => $body], function ($send) use ($mail_val) {
                $send->from($mail_val['email_from'], $mail_val['email_from_name']);
                $send->replyto($mail_val['email_from'], $mail_val['email_from_name']);
                $send->to($mail_val['send_to'], $mail_val['send_to_name'])->subject($mail_val['subject']);
            });
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            // echo "An error occurred while sending the email: " . $e->getMessage();
            return false;
        }
    }
}


