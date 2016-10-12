<?php

namespace App\Email;

use App\Jobs\SendEmail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Mail;
use Exception;
use Mailgun\Mailgun;

class EmailManager
{
	use DispatchesJobs;

	public function storeEmail($data)
	{
		$data['from'] = isset($data['from']) ? $data['from'] : trans('www.email.default.from');
		$data['from_name'] = isset($data['from_name']) ? $data['from_name'] : trans('www.email.default.from_name');
		$data['reply_to'] = isset($data['reply_to']) ? $data['reply_to'] : $data['from'];
		$data['status'] = Email::STATUS_PENDING;

		//Email::create($data);
		//shell_exec('php '.base_path().'/artisan schedule:run > /dev/null 2>/dev/null &');

		$email = new Email($data);
		$email->save();

		$this->dispatch(new SendEmail($email));
	}

	/*public static function sendEmails()
	{
		$newEmails = Email::where('status', Email::STATUS_PENDING)->orderBy('id', 'desc')->get();
		foreach ($newEmails as $email) {

			Mail::send('emails.default', ['email' => $email], function ($message) use ($email) {
					$message->from($email->from, $email->from_name);
					$message->to($email->to, $email->to_name);
					$message->subject($email->subject);
				});

			$email->status = Email::STATUS_SENT;
			$email->save();
		}
	}*/

	public function sendEmail(Email $email)
	{
        try {
            $template = empty($email->template) ? 'default' : $email->template;
            Mail::send(['email.'.$template.'_html', 'email.'.$template], ['email' => $email], function($message) use($email) {
                $message->from($email->from, $email->from_name);
                $message->to($email->to, $email->to_name);
                $message->replyTo($email->reply_to);
                $message->subject($email->subject);
            });

            # Instantiate the client.
            /*$mgClient = new Mailgun('key-58ca7914635e0fc6121051e1c4069e31');
            $domain = "mg.autotrade.am";

            # Make the call to the client.
            $result = $mgClient->sendMessage($domain, array(
                'from'    => $email->from_name.' <'.$email->from.'>',
                'to'      => $email->to_name.' <'.$email->to.'>',
                'subject' => $email->subject,
                'text'    => trim(str_replace('&nbsp;', '', strip_tags($email->body))),
                'html'    => $email->body,
            ));*/

            $email->status = Email::STATUS_SENT;
        } catch (Exception $e) {
            $email->status = Email::STATUS_FAILED;
        }
		$email->save();
	}
}