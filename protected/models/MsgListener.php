<?php
/**
 * --请填写模块名称--
 *
 * @author #sudk#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class MsgListener extends CActiveRecord {

    const TYPE_NOTICE=1;
    const TYPE_MSG=2;
    const TYPE_ALA=3;
    //1)通知，2）消息，3）提醒
    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return "g_msg_listener";
    }

    public function rules(){
        return array(
            //安全性
            array('msgid,listener,listenerid,sender,senderid,type,title,record_time,isread', 'safe', 'on' => 'create'),
            array('msgid,listener,listenerid,sender,senderid,type,title,record_time,isread', 'safe', 'on' => 'modify'),

            //array('password', 'compare', 'compareAttribute'=>'passwordc', 'on'=>'create,modify'),
        );
    }

    public static function  GetType($s = "")
    {
        $ar=array(
            self::TYPE_NOTICE=>"公告",
            self::TYPE_MSG=>"消息",
            self::TYPE_ALA=>"提醒",
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

        if ($args['msgid'] != ''){
            $condition.= ' AND msgid=:msgid';
            $params['msgid'] = $args['msgid'];
        }
        if ($args['title'] != ''){
            $condition.=' AND title like :title';
            $params['title'] = "%".$args['title']."%";
        }
        if ($args['listenerid'] != ''){
            $condition.=' AND listenerid=:listenerid';
            $params['listenerid'] = $args['listenerid'];
        }
        if ($args['listener'] != ''){
            $condition.=' AND listener=:listener';
            $params['listener'] = $args['listener'];
        }
        if ($args['sender'] != ''){
            $condition.= ( $condition == '') ? ' sender=:sender' : ' AND sender=:sender';
            $params['sender'] = $args['sender'];
        }
        if ($args['type'] != ''){
            $condition.= ( $condition == '') ? ' type=:type' : ' AND type=:type';
            $params['type'] = $args['type'];
        }
        if ($args['isread'] != ''){
            $condition.= ( $condition == '') ? ' isread=:isread' : ' AND isread=:isread';
            $params['isread'] = $args['isread'];
        }
        if ($args['startdate'] != ''){
            $condition.=' AND record_time>=:startdate';
            $params['startdate'] = $args['startdate'];
        }
        if ($args['enddate'] != ''){
            $condition.=' AND record_time<=:enddate';
            $params['enddate'] = $args['enddate']." 23:59:59";
        }
        $total_num = MsgListener::model()->count($condition, $params); //总记录数

        $criteria = new CDbCriteria();

        if($_REQUEST['q_order']==''){
            $criteria->order = 'record_time  DESC';
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

        $rows = MsgListener::model()->findAll($criteria);

        $rs['status'] = 0;
        $rs['desc'] = '成功';
        $rs['page_num'] = ($pages->currentPage + 1);
        $rs['total_num'] = $total_num;
        $rs['total_page'] = ceil($rs['total_num'] / $rs['page_num']);
        $rs['num_of_page'] = $pages->pageSize;
        $rs['rows'] = $rows;

        return $rs;
    }

    public static function GetByCd($condition,$params=array(),$limit=20,$offset=0,$order='record_time DESC'){
        $total_num = MsgListener::model()->count($condition, $params);
        $rows= Yii::app()->db->createCommand()
            ->select("*")
            ->from("g_msg_listener")
            ->where($condition,$params)
            ->order($order)
            ->limit($limit)
            ->offset($offset)
            ->queryAll();
        return array('count'=>$total_num,'rows'=>$rows);
    }

    public static function SetReaded($msgid,$listenerid){
        try{
            //设信息为已读
            $sql = " UPDATE g_msg_listener  set isread=1 WHERE msgid='{$msgid}' and listenerid='{$listenerid}' ";
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
            return true;
        }catch (Exception $e){
            return false;
        }
    }

}


    