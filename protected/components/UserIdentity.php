<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
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
        return $this->auth_system();
    }

    public function auth_system()
    {
        $operator = Operator::model()->find('id=:id ', array(':id' => $this->username));

        //var_dump($operator);exit;
        if ($operator == null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        }
        if ($operator->status != Operator::STATUS_NORMAL) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        }

        if (crypt($this->password,$operator->password) != $operator->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
        }
        Yii::app()->user->setState('id', $operator->id);
        Yii::app()->user->setState('name', $operator->name);
        Yii::app()->user->setState('type', $operator->type);
        Yii::app()->user->setState('agent_id', $operator->agent_id);
        Yii::app()->user->setState('auths', Auth::GetAuth($operator->id));
        Yii::app()->user->setState('data', Auth::GetData(Yii::app()->user->auths));

        $this->errorCode = self::ERROR_NONE;
        
        //add log
        $log_args = array(
            'module_id'=>'system',
            'opt_name'=>'管理员登陆',
            'opt_detail'=>'管理员登陆',
            'opt_status'=>'00',
        );
        Operatorlog::addLog($log_args);

        return !$this->errorCode;
    }
}