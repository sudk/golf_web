<?php

/**
 * 赛事
 * @author sudk
 */
class NewsController extends CMDBaseController
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
        if(!Yii::app()->command->cmdObj->_pg_){
            $msg['status']=1;
            $msg['desc']="分页参数不能为空！";
            echo json_encode($msg);
            return;
        }
        $args=array();
        if(Yii::app()->command->cmdObj->tile){
            $args['tile']=Yii::app()->command->cmdObj->tile;
        }
        //echo Yii::app()->command->cmdObj->_pg_[1];
        $rs=News::queryList(Yii::app()->command->cmdObj->_pg_[0],Yii::app()->command->cmdObj->_pg_[1],$args);
        if($rs['rows']){
            $msg['status']=0;
            $msg['desc']="成功";
            $msg['_pg_']=array(Yii::app()->command->cmdObj->_pg_[0],Yii::app()->command->cmdObj->_pg_[1],$rs['total_page'],$rs['total_num']);
            $msg['data']=$rs['rows'];
        }else{
            $msg['status']=4;
            $msg['desc']="没有数据";
        }
        echo json_encode($msg);
        return;

    }

    public function actionInfo(){
        if(!Yii::app()->command->cmdObj->id){
            $msg['status']=1;
            $msg['desc']="ID不能为空！";
            echo json_encode($msg);
            return;
        }
        $row=News::Info(Yii::app()->command->cmdObj->id);
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
}