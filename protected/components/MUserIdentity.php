<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class MUserIdentity extends CUserIdentity
{

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        return $this->auth();
    }

    private function auth()
    {
        $user=User::model()->find('phone=:phone ', array(':phone' => $this->username));
        //var_dump($user);
        //var_dump($operator);exit;
        if ($user == null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        }
        if ($user->status != User::STATUS_NORMAL) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        }

        if (substr(crypt($this->password,$user->passwd),0,strlen($user->passwd)) != $user->passwd) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
        }

        $this->errorCode = self::ERROR_NONE;

        return !$this->errorCode;
    }
}