<?php
/**
 * --请填写模块名称--
 *
 * @author #sudk#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class MsgBox extends CActiveRecord {

    const TYPE_NOTICE=1;
    const TYPE_MSG=2;
    
//    const TYPE_ALA=3;
//    const TYPE_VISIT=4;
//    const TYPE_WORK=5;
    //1)通知，2）消息，3）提醒 ，4）回访提醒，5）审核提醒
    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return "g_msg_box";
    }

    public function rules(){
        return array(
            //安全性
            array('id,title,content,creatorid,creator,type,recordtime', 'safe', 'on' => 'create'),
            array('id,title,content,creatorid,creator,type,recordtime', 'safe', 'on' => 'modify'),

            //array('password', 'compare', 'compareAttribute'=>'passwordc', 'on'=>'create,modify'),
        );
    }

    public static function  GetType($s = "")
    {
        $ar=array(
            self::TYPE_NOTICE=>"公告",
            self::TYPE_MSG=>"消息",
            //self::TYPE_ALA=>"提醒",
        );
        return trim($s)?$ar[$s]:$ar;
    }

    /**
     * 查询
     * @param int $page
     * @param int $pageSize
     * @param array $args
     * @return array
     */
    /**
     * 查询
     * @param int $page
     * @param int $pageSize
     * @param array $args
     * @return array
     */
    public static function queryList($page, $pageSize, $args = array()) {

        $condition = ' 1=1 ';
        $params = array();

        if ($args['id'] != ''){
            $condition.= ' AND id=:id';
            $params['id'] = $args['id'];
        }
        if ($args['title'] != ''){
            $condition.= ' AND title like :title';
            $params['title'] = "%".$args['title']."%";
        }
        if ($args['creator'] != ''){
            $condition.=' AND creator=:creator';
            $params['creator'] = $args['creator'];
        }
        if ($args['type'] != ''){
            $condition.=' AND type=:type';
            $params['type'] = $args['type'];
        }
        if ($args['startdate'] != ''){
            $condition.=' AND record_time>=:startdate';
            $params['startdate'] = $args['startdate'];
        }
        if ($args['enddate'] != ''){
            $condition.=' AND record_time<=:enddate';
            $params['enddate'] = $args['enddate']." 23:59:59";
        }
        $total_num = MsgBox::model()->count($condition, $params); //总记录数

        $criteria = new CDbCriteria();

        if($_REQUEST['q_order']==''){
            $criteria->order = ' record_time  DESC';
        }else{
            if(substr($_REQUEST['q_order'],-1)=='~')
                $criteria->order = substr($_REQUEST['q_order'],0,-1).' DESC';
            else
                $criteria->order = $_REQUEST['q_order'].' ASC';
        }

        $criteria->condition = $condition;
        $criteria->params = $params;

        $pages = new CPagination($total_num);
        $pages->pageSize = $pageSize;
        $pages->setCurrentPage($page);
        $pages->applyLimit($criteria);

        $rows = MsgBox::model()->findAll($criteria);

        $rs['status'] = 0;
        $rs['desc'] = '成功';
        $rs['page_num'] = ($pages->currentPage + 1);
        $rs['total_num'] = $total_num;
        $rs['total_page'] = ceil($rs['total_num'] / $rs['page_num']);
        $rs['num_of_page'] = $pages->pageSize;
        $rs['rows'] = $rows;

        return $rs;
    }

    /*
     * listeners=array('listener1','listener3','listener2')
     * */
    public static function SendMsg($title,$content,$creatorid,$type,$listeners=array()){
        $rs['status']=false;
        $rs['desc']="发送消息成功！";
        if(trim($title)==""||$title==null){
           $rs['desc']="消息标题不能为空！";
           return $rs;
        }
        if(trim($creatorid)==""||$creatorid==null){
            $rs['desc']="消息发送人不能为空！";
            return $rs;
        }
        if(trim($content)==""||$content==null){
            $rs['desc']="消息内容不能为空！";
            return $rs;
        }
        if(empty($listeners)){
            $rs['desc']="消息接收人不能为空！";
            return $rs;
        }
        if(trim($type)==""||$type==null){
            $type=self::TYPE_NOTICE;
        }
        $id=date("YmdHis").$creatorid;
        $recordtime=date("Y-m-d H:i:s");
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try {
            $sql = "
            insert into g_msg_box
            (id,title,content,`type`,creator,creatorid,record_time)
            values
            ('{$id}',:title,:content,'{$type}',(select name from g_operator where id='{$creatorid}'),'{$creatorid}','{$recordtime}')";
            //$connection->createCommand($sql)->execute();
            $command = $connection->createCommand($sql);
            $command->bindParam(":title", $title, PDO::PARAM_STR);
            $command->bindParam(":content", $content, PDO::PARAM_STR);
            $command->execute();
            foreach($listeners as $listener){
                if(!trim($listener)){
                    continue;
                }
                $sql="
                insert into g_msg_listener
                (msgid,listener,listenerid,sender,senderid,`type`,title,record_time)
                values
                ('{$id}',(select name from g_operator where id='{$listener}'),'{$listener}',(select name from g_operator where id='{$creatorid}'),'{$creatorid}','{$type}','{$title}','{$recordtime}')
                ";
                $connection->createCommand($sql)->execute();
            }

            $transaction->commit();
            $rs['status']=true;
            return $rs;
        }
        catch (Exception $e)
        {
            print_r($e->getMessage());
            $transaction->rollBack();
            $rs['desc']="发送消息失败！";
            return $rs;
        }

    }
}


    