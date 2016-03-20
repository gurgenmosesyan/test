<?php

namespace App\Models\User;

use App\Email\EmailManager;
use DB;

class UserManager
{
    public function generateRandomUniqueHash($count = 40)
    {
        $hash = str_random($count);
        $user = User::active()->where('hash', $hash)->first();
        if ($user == null) {
            return $hash;
        }
        return $this->generateRandomUniqueHash();
    }

    public function registration($data)
    {
        $user = new User($data);
        $user->password = bcrypt($user->password);
        $user->hash = self::generateRandomUniqueHash();
        $user->status = User::STATUS_REGISTERED;

        DB::transaction(function() use($user) {
            $user->save();

            $link = url_with_lng('/activation/'.$user->hash, false);
            $body = trans('www.user.email.confirm.text', ['link' => '<a href="'.$link.'">'.$link.'</a>']);
            $emailManager = new EmailManager();
            $emailManager->storeEmail([
                'to' => $user->email,
                'to_name' => $user->first_name.' '.$user->last_name,
                'subject' => trans('www.user.email.confirm.subject'),
                'body' => $body
            ]);
        });
        return true;
    }

    public function forgot($data)
    {
        $user = User::active()->where('email', $data['email'])->firstOrFail();

        $link = url_with_lng('/reset/'.$user->hash, false);
        $body = trans('www.user.email.forgot.text', ['link' => '<a href="'.$link.'">'.$link.'</a>']);

        $emailManager = new EmailManager();
        $emailManager->storeEmail([
            'to' => $user->email,
            'to_name' => $user->first_name.' '.$user->last_name,
            'subject' => trans('www.user.email.forgot.subject'),
            'body' => $body
        ]);
        return true;
    }

    public function reset($data)
    {
        $user = User::active()->where('hash', $data['hash'])->firstOrFail();
        $user->password = bcrypt($data['password']);
        $user->hash = $this->generateRandomUniqueHash();
        $user->save();
        return true;
    }
}