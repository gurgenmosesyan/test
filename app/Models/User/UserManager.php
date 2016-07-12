<?php

namespace App\Models\User;

use App\Email\EmailManager;
use Auth;
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
        $user->birthday = '0000-00-00';
        $user->gender = '';
        $user->balance = 0;
        $user->password = bcrypt($user->password);
        $user->hash = self::generateRandomUniqueHash();
        $user->status = User::STATUS_REGISTERED;
        $user->show_status = User::STATUS_ACTIVE;
        $user->save();

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

    public function getFBUser($userNode)
    {
        $user = User::active()->where('social', User::SOCIAL_FB)->where('social_id', $userNode->getId())->first();
        if ($user == null) {
            $userData = $this->getFBUserData($userNode);
            if (!empty($userData['email'])) {
                $this->resetAfterDay();
                $user = User::active()->where('email', $userData['email'])->first();
                if ($user != null) {
                    $userData['email'] = '';
                }
            }
            $user = $this->addFBUser($userData);
        }
        return $user;
    }

    public function getFBUserData($userNode)
    {
        $data = [];
        $data['social_id'] = $userNode->getId();
        $data['email'] = empty($userNode->getEmail()) ? '' : $userNode->getEmail();
        $data['first_name'] = $userNode->getFirstName();
        $data['last_name'] = $userNode->getLastName();
        $name = explode(' ', $userNode->getName());
        if (empty($data['first_name'])) {
            $data['first_name'] = $name[0];
        }
        if (empty($data['last_name']) && isset($name[1])) {
            $data['last_name'] = $name[1];
        }
        return $data;
    }

    public function addFBUser($data)
    {
        $user = new User($data);
        $user->social = User::SOCIAL_FB;
        $user->hash = self::generateRandomUniqueHash();
        $user->status = User::STATUS_CONFIRMED;
        $user->save();
        return $user;
    }

    public function getGoogleUser($person)
    {
        $user = User::active()->where('social', User::SOCIAL_GP)->where('social_id', $person->getId())->first();
        if ($user == null) {
            $userData = $this->getGoogleUserData($person);
            $this->resetAfterDay();
            $user = User::active()->where('email', $userData['email'])->first();
            if ($user != null) {
                $userData['email'] = '';
            }
            $user = $this->addGoogleUser($userData);
        }
        return $user;
    }

    public function getGoogleUserData($person)
    {
        return [
            'social_id' => $person->getId(),
            'email' => $person->getEmails()[0]->value,
            'first_name' => $person->getName()->givenName,
            'last_name' => $person->getName()->familyName
        ];
    }

    public function addGoogleUser($data)
    {
        $user = new User($data);
        $user->social = User::SOCIAL_GP;
        $user->hash = self::generateRandomUniqueHash();
        $user->status = User::STATUS_CONFIRMED;
        $user->save();
        return $user;
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
    }

    public function editProfile($data)
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        $user = Auth::guard('user')->user();
        $user->update($data);
    }

    public function resetAfterDay()
    {
        $oneDay = date('Y-m-d H:i:s', time() - 86400);
        User::active()->where('status', User::STATUS_REGISTERED)->where('created_at', '<', $oneDay)->update(['show_status' => User::STATUS_DELETED]);
    }
}