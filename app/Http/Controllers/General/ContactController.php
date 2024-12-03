<?php

namespace App\Http\Controllers\General;

use App\Models\Admin;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Notifications\SendContactNotify;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(['throttle:contact', 'can:contacts']);
    }
    public function store(ContactRequest $request)
    {
        $contact = Contact::create($request->all());
        if(!$contact){
            return responseApi(403, 'Invalid Contact Request');
        }

        $admin = Admin::get();
        Notification::send($admin, new SendContactNotify($contact));
        return responseApi(201, 'Contact Request Received');
    }
}
