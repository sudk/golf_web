<?php

/**
 * 用户接口
 * @author sudk
 */
class CourtController extends CMDBaseController
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

    public function actionSearch(){
        if(!Yii::app()->command->cmdObj->city){
            $msg['status']=1;
            $msg['desc']="城市不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->date){
            $msg['status']=2;
            $msg['desc']="日期不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->time){
            $msg['status']=3;
            $msg['desc']="时段不能为空！";
            echo json_encode($msg);
            return;
        }
        $rows=Court::Search(Yii::app()->command->cmdObj);
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

    public function actionInfo(){
        if(!Yii::app()->command->cmdObj->court_id){
            $msg['status']=1;
            $msg['desc']="球场ID不能为空！";
            echo json_encode($msg);
            return;
        }
        $row=Court::Info(Yii::app()->command->cmdObj->court_id);
        if($row){
            $msg['status']=0;
            $msg['desc']="成功";
            $msg['data']=$row;
        }else{
            $msg['status']=4;
            $msg['desc']="没有数据";
        }
        echo json_encode($msg);
        return;

    }

    public function actionPrice(){
        if(!Yii::app()->command->cmdObj->court_id){
            $msg['status']=1;
            $msg['desc']="球场ID不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->date_time){
            $msg['status']=1;
            $msg['desc']="打球日期时间不能为空！";
            echo json_encode($msg);
            return;
        }
        $rows=Court::Price(Yii::app()->command->cmdObj);
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