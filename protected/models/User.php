<?php
/**
 * --请填写模块名称--
 *
 * @author #guohao 
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class User extends CActiveRecord {

    const STATUS_NORMAL=0;//正常
    const STATUS_DISABLE=-1;//禁用

    const SEX_MEN="0";
    const SEX_WOMEN="1";

    

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'g_user';
    }

    public function rules(){
        return array(
             //安全性
            array('user_id,user_name,phone,card_no,email,sex,remark,record_time,status,balance,point', 'safe', 'on' => 'modify'),
            array('user_id,user_name,phone,card_no,passwd,email,sex,remark,record_time,status,balance,point', 'safe', 'on' => 'create'),
            array('phone,passwd','required','on'=>'create'),
            //array('password', 'compare', 'compareAttribute'=>'passwordc', 'on'=>'create,modify'),
         );
    }


    public static function  GetSex($s = "")
    {
        $ar=array(
            "0"=>"男",
            "1"=>"女",
        );
        return trim($s)!=""?$ar[$s]:$ar;
    }

    public static function  GetStatus($s = "")
    {
        $ar=array(
            self::STATUS_NORMAL=>"正常",
            self::STATUS_DISABLE=>"禁用",
        );
        return trim($s)!=""?$ar[$s]:$ar;
    }


    /**
     * 删除
     * @param  string authitemid
     * @return array
     */
    public function delete($authitemid=null) {

    	$authitemid = trim($authitemid);

    	//检查非空性
    	if($authitemid == ''){
    	   $r['message'] = '主键为空，不能删除';
           $r['refresh'] = false;
           return $r;
    	}

        $sql = 'DELETE FROM operator WHERE mchtid=:mchtid';
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":authitemid", $authitemid, PDO::PARAM_STR);
        $rs = $command->execute();

        if ($rs == 0)
        {
            $r['message'] = '您要删除的记录不存在！';
            $r['refresh'] = false;
        }
        else
        {
            $r['message'] = '删除成功';
            $r['refresh'] = true;
        }
        return $r;
    }

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

        if ($args['user_id'] != ''){
            $condition.= ' AND user_id=:user_id';
            $params['user_id'] = $args['user_id'];
        }
        if ($args['user_name'] != ''){
            $condition.=' AND user_name like :user_name';
            $params['name'] = "%".$args['user_name']."%";
        }
        if ($args['status'] != ''){
            $condition.= ' AND status=:status';
            $params['status'] = $args['status'];
        }
        if ($args['phone'] != ''){
            $condition.=' AND phone=:phone';
            $params['phone'] = $args['phone'];
        }
        if ($args['card_no'] != ''){
            $condition.=' AND card_no = :card_no';
            $params['card_no'] = $args['card_no'];
        }
        
        $total_num = User::model()->count($condition, $params); //总记录数

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

        $rows = User::model()->findAll($criteria);

        $rs['status'] = 0;
        $rs['desc'] = '成功';
        $rs['page_num'] = ($pages->currentPage + 1);
        $rs['total_num'] = $total_num;
        $rs['total_page'] = ceil($rs['total_num'] / $rs['page_num']);
        $rs['num_of_page'] = $pages->pageSize;
        $rs['rows'] = $rows;

        return $rs;
    }

    public static function FindOneByPhone($phone){
        $row = Yii::app()->db->createCommand()
            ->select("user_id,user_name,phone,card_no,email,sex,remark,record_time,status,balance,point")
            ->from("g_user")
            ->where("phone='{$phone}'")
            ->queryRow();
        return $row;
    }

    public static function GetBoxAr(){

    	$rows = Yii::app()->db->createCommand()
    	->select("id,name,type,abbreviation")
    	->from("g_operator")
    	->order("abbreviation")
    	->queryAll();
    	$ar=array(""=>"--请选择--");
    	if($rows){
    		foreach($rows as $row){
    			$ar[$row['id']]=$row['name'];
    		}
    	}
    	return $ar;
    }
}


    