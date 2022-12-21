<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Api\FrontController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact;
use App\Mail\Contacts;
use App\Models\Branch;
use Mail;
class ContactUSController extends Controller
{
    public function contactPage()
    {
        $branches = Branch::all();
        
        return view('website.page-contacts', compact('branches'));
    }


    public function store(Request $request)
    {
        $req = $request->validate([
            'body' => 'required|string',
            'subject' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);
        
        $user = Auth::user();
        $contact = new Contact;
        $contact->subject = $request->subject;
        $contact->body = $request->body;
        $contact->customer_id = $user->id;
        $contact->save();

        // Mail::to("kop@wahfyservices.com")
        //     ->send(new Contacts($contact));
        return redirect()->back()->with(['success' => __('general.Contact Message Sent')]);
    }
}
