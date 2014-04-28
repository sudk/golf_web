<?php

/**
 * 赛事
 * @author sudk
 */
class AdvController extends CMDBaseController
{
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('info','Bandcard'),
                'users' => array('@'),
            ),
            array('allow',
                'users' => array('*'),
            ),
            array('deny',
                'actions' => array(),
            ),
        );
    }

    public function actionList(){
        if(!Yii::app()->command->cmdObj->type){
            $msg['status']=1;
            $msg['desc']="广告类型不能为空！";
            echo json_encode($msg);
            return;
        }

        $rows=Adv::Adv_list(Yii::app()->command->cmdObj->type);
        if($rows){
            $msg['status']=0;
            $msg['desc']="成功";
            $msg['data']=$rows;
        }else{
            $msg['status']=4;
            $msg['desc']="没有数据";
        }
        echo json_encode($msg);
        return;
    }

}