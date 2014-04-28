<?php
/*
 * 模块编号: M1001
 */
class CommandController extends MBaseController
{
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index'),
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

    public function actionIndex(){
        Yii::app()->runController("cmd/".Yii::app()->command->cmd);
    }

}