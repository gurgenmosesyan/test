<?php

namespace App\Http\Controllers;

use App\Email\EmailManager;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function indexApi(ContactRequest $request)
    {
        $data = $request->all();

        $body = '<p>'.$data['name'].' ('.$data['email'].')</p>';
        $body .= '<br />';
        $body .= '<p>'.$data['message'].'</p>';

        $emailManager = new EmailManager();
        $emailManager->storeEmail([
            'to' => trans('www.contacts.to_email'),
            'to_name' => trans('www.contacts.to_name'),
            'from' => $data['email'],
            'from_name' => $data['name'],
            'subject' => trans('www.contacts.subject'),
            'body' => $body,
            'template' => 'default'
        ]);

        return $this->api('OK');
    }
}