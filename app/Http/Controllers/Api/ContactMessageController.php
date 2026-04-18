<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);
        $contact = new ContactMessage();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->visitor_id = $request->visitor_id;
        $contact->save();
        return response()->json(['success' => true]);
    }
}
