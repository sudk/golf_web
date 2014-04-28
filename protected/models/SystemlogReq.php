<?php
/**
 * --请填写模块名称--
 *
 * @author #author#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class SystemlogReq extends CActiveRecord {

    const TYPE_SAVE_FALSE=1;
    const TYPE_GET_FALSE=2;
    const TYPE_ANAL_FALSE=3;
    const TYPE_CONN_FALSE=4;
    //1)保存失败，2）远端获取失败，3）模板解析失败
    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return "g_system_log_req";
    }

    public function rules(){
        return array(
         );
    }

    public static function  GetType($s = "")
    {
        $ar=array(
            self::TYPE_SAVE_FALSE=>"保存失败",
            self::TYPE_GET_FALSE=>"远端获取失败",
            self::TYPE_ANAL_FALSE=>"模板解析失败",
            self::TYPE_CONN_FALSE=>"远端连接失败",
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
    public static function queryList($page, $pageSize, $args = array()) {


        $condition = '';
        $params = array();

        if ($args['logid'] != ''){
            $condition.= ( $condition == '') ? ' logid=:logid' : ' AND logid=:logid';
            $params['logid'] = $args['logid'];
        }
        $table=self::getTable($args['startdate']);
        //$total_num = Translog::model()->count($condition, $params); //总记录数
        $total_num = Yii::app()->db->createCommand()
            ->select("count(1) c")
            ->from($table)
            ->where($condition, $params)
            ->queryRow();

        
    	if($_REQUEST['q_order']==''||!isset($_REQUEST['q_order'])){
            $order = 'settdate DESC ';
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
            $table="system_log_req_".$date_str;
        }else{
            $settdate=str_replace("-","",$settdate);
            $date_str=substr($settdate,0,6);
            $table="system_log_req_".$date_str;
        }
        try{
            Yii::app()->db->createCommand('create table if not exists `'.$table.'` like system_log_req')->execute();
        }catch (Exception $e){
            echo "";
        }
        return $table;
    }

    public static function GetReqByPk($pk,$recordtime){
        $table=self::getTable($recordtime);
        $row = Yii::app()->db->createCommand()
            ->select("request")
            ->from($table)
            ->where("logid='{$pk}'")
            ->queryRow();
        return $row['request'];
    }
}


    