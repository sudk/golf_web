<?php
/*
 * 模块编号: M1001
 */
class DboardController extends AuthBaseController
{

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'actions' => array(),
            ),
        );
    }

	public function actionIndex()
	{
        return $this->actionSystem();
	}

	public function actionSystem()
	{
            //var_dump(Yii::app()->user->auths);
            //var_dump(Yii::app()->user->data);
            if(Yii::app()->user->type == Operator::TYPE_AGENT)
            {
                $this->render('system');
            }else{
                $this->render('system_s');
            }
	}

}