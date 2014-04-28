<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MBaseController extends CController
{
    public $cmdObj;
    public $cmd;

    const WRONG_FORMAT=-1;
    const SUCCESS=0;
    const NAME_OR_PASSWORD_FALSE=1;
    const KEY_TIME_OUT=-2;
    const MISSING_PARAMETER=-3;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('login','security'),
                'users' => array('*'),
            ),
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'actions' => array(),
            ),
        );
    }

     public function init()
     {
         //session_start();
     }

    /**
	 * Checks if rbac access is granted for the current user
	 * @param String $action . The current action
	 * @return boolean true if access is granted else false
	*/
	protected function beforeAction($action)
	{
        if(Yii::app()->command->cmdObj){
            if(isset(Yii::app()->command->cmd)){
                return true;
            }else{
                echo json_encode(array('result'=>self::MISSING_PARAMETER,'desc'=>Yii::app()->params['cmd_status'][self::MISSING_PARAMETER]));
                return false;
            }
        }else{
            echo json_encode(array('result'=>self::WRONG_FORMAT,'desc'=>Yii::app()->params['cmd_status'][self::WRONG_FORMAT]));
            return false;
        }
    }
}