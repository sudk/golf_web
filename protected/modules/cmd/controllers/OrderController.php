<?php

/**
 * 赛事
 * @author sudk
 */
class OrderController extends CMDBaseController
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

    public function actionCreate(){
        if(!Yii::app()->command->cmdObj->type){
            $msg['status']=1;
            $msg['desc']="订单类型不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->relation_id){
            $msg['status']=2;
            $msg['desc']="关联ID不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->relation_name){
            $msg['status']=3;
            $msg['desc']="项目名称不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->tee_time){
            $msg['status']=5;
            $msg['desc']="打球时间不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->count){
            $msg['status']=6;
            $msg['desc']="数量不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->unitprice){
            $msg['status']=7;
            $msg['desc']="单价不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->amount){
            $msg['status']=8;
            $msg['desc']="购买数量不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->pay_type){
            $msg['status']=9;
            $msg['desc']="支付类型不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->contact){
            $msg['status']=10;
            $msg['desc']="联系人不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->phone){
            $msg['status']=11;
            $msg['desc']="电话不能为空！";
            echo json_encode($msg);
            return;
        }
        if(!Yii::app()->command->cmdObj->agent_id){
            $msg['status']=12;
            $msg['desc']="代理商ID不能为空！";
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