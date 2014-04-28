<?php
/**
 * --请填写模块名称--
 *
 * @author #sudk#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class Systemlog extends CActiveRecord {


    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return "g_system_log";
    }

    public function rules(){
        return array(
         );
    }

    /**
     * 查询
     * @param int $page
     * @param int $pageSize
     * @param array $args
     * @return array
     */
    public static function queryList($page, $pageSize, $args = array()) {


        $condition = '';
        $params = array();

        if ($args['userid'] != ''){
            $condition.= ( $condition == '') ? ' userid=:userid' : ' AND userid=:userid';
            $params['userid'] = $args['userid'];
        }
        if ($args['username'] != ''){
            $condition.= ( $condition == '') ? ' username like :username' : ' AND username like :username';
            $params['username'] = "%".$args['username']."%";
        }
        if ($args['operation'] != ''){
            $condition.= ( $condition == '') ? ' operation=:operation' : ' AND operation=:operation';
            $params['operation'] = $args['operation'];
        }
        if ($args['ip'] != ''){
            $condition.= ( $condition == '') ? ' ip=:ip' : ' AND ip=:ip';
            $params['ip'] = $args['ip'];
        }
        if ($args['startdate'] != ''){
            $condition.= ( $condition == '') ? ' recordtime >=:startdate' : ' AND recordtime>=:startdate';
            $params['startdate'] = $args['startdate'];
        }
        if ($args['enddate'] != ''){
            $condition.= ( $condition == '') ? ' recordtime<=:enddate' : ' AND recordtime<=:enddate';
            $params['enddate'] = $args['enddate']." 23:59:59";
        }
        $table=self::getTable($params['startdate']);
        //$total_num = Translog::model()->count($condition, $params); //总记录数
//        print_r($condition);
//        print_r($params);
//        print_r($table);
        $total_num = Yii::app()->db->createCommand()
            ->select("count(1) c")
            ->from($table)
            ->where($condition, $params)
            ->queryRow();

        
    	if($_REQUEST['q_order']==''||!isset($_REQUEST['q_order'])){
            $order = 'recordtime DESC ';
        }else{
            if(substr($_REQUEST['q_order'],-1)=='~')
                $order = substr($_REQUEST['q_order'],0,-1).' DESC';
            else
                $order = $_REQUEST['q_order'].' ASC';
        }
        //$rows = Translog::model()->findAll($criteria);

        $rows = Yii::app()->db->createCommand()
            ->select("*")
            ->from($table)
            ->where($condition, $params)
            ->order($order)
            ->limit($pageSize)
            ->offset($page * $pageSize)
            ->queryAll();

        $rs['status'] = 0;
        $rs['desc'] = '成功';
        $rs['page_num'] = ($page+1);
        $rs['total_num'] = $total_num['c'];
        $rs['num_of_page'] = $pageSize;
        $rs['rows'] = $rows;

        return $rs;
    }

    public static function getTable($settdate=""){
        if($settdate==""){
            $date_str=date("Ym");
            //$date_str=substr($date_str,0,6);
            $table="g_system_log_".$date_str;
        }else{
            $settdate=str_replace("-","",$settdate);
            $date_str=substr($settdate,0,6);
            $table="g_system_log_".$date_str;
        }
        try{
            Yii::app()->db->createCommand('create table if not exists `'.$table.'` like g_system_log')->execute();
        }catch (Exception $e){
            echo "";
        }
        return $table;
    }
    
   
}


    