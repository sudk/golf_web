<?php
/**
 * --请填写模块名称--
 *
 * @author #sudk <sudk@trunkbow.com>#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class Operator extends CActiveRecord {

    const STATUS_NORMAL=1;//正常
    const STATUS_DISABLE=-1;//禁用

    const SEX_MEN=0;
    const SEX_WOMEN=1;
    
    
    const TYPE_SYS = 1;
    const TYPE_AGENT = 2;

    public $passwordc;

    public $cities;

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'g_operator';
    }

    public function rules(){
        return array(
             //安全性
            array('id,agent_id,name,loginid,password,passwordc,type,tel,email,qq,jobtitle,abbreviation,creator,remark,record_time,status,sex', 'safe', 'on' => 'create'),
            array('id,agent_id,name,loginid,password,passwordc,type,tel,email,qq,jobtitle,abbreviation,creator,remark,record_time,status,sex', 'safe', 'on' => 'modify'),

            //array('password', 'compare', 'compareAttribute'=>'passwordc', 'on'=>'create,modify'),
         );
    }


    public static function  GetSex($s = "")
    {
        $ar=array(
            self::SEX_MEN=>"男",
            self::SEX_WOMEN=>"女",
        );
        return trim($s)?$ar[$s]:$ar;
    }

    public static function  GetStatus($s = "")
    {
        $ar=array(
            self::STATUS_NORMAL=>"正常",
            self::STATUS_DISABLE=>"禁用",
        );
        return trim($s)!=""?$ar[$s]:$ar;
    }
    
    
    public static function  GetType($s = "")
    {
        $ar=array(
            self::TYPE_SYS=>"系统管理员",
            self::TYPE_AGENT=>"代理商",
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

        if ($args['id'] != ''){
            $condition.= ' AND id=:id';
            $params['id'] = $args['id'];
        }
        if ($args['staffname'] != ''){
            $condition.=' AND name like :name';
            $params['name'] = "%".$args['name']."%";
        }
        if ($args['type'] != ''){
            $condition.= ' AND type=:type';
            $params['type'] = $args['type'];
        }
        if ($args['tel'] != ''){
            $condition.=' AND tel=:tel';
            $params['tel'] = $args['tel'];
        }
        if ($args['pin'] != ''){
            $condition.=' AND abbreviation like :pin';
            $params['pin'] = $args['pin']."%";
        }
        if ($args['status'] != ''){
            $condition.=' AND status=:status';
            $params['status'] = $args['status'];
        }
        if ($args['type'] != ''){
            $condition.=' AND type=:type';
            $params['type'] = $args['type'];
        }
        $total_num = Operator::model()->count($condition, $params); //总记录数

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

        $rows = Operator::model()->findAll($criteria);

        $rs['status'] = 0;
        $rs['desc'] = '成功';
        $rs['page_num'] = ($pages->currentPage + 1);
        $rs['total_num'] = $total_num;
        $rs['total_page'] = ceil($rs['total_num'] / $rs['page_num']);
        $rs['num_of_page'] = $pages->pageSize;
        $rs['rows'] = $rows;

        return $rs;
    }


    public static function GetAr($t="",$has_type=false){
        $rows = Yii::app()->db->createCommand()
                ->select("id,name,type,abbreviation")
                ->from("g_operator")
                ->order("abbreviation")
                ->queryAll();
        if($has_type){
            $ar=array();
            if($rows){
                foreach($rows as $row){
                    $ar[$row['type']][$row['id']]=$row['name'];
                }
            }
        }else{
            $ar=array(""=>"--请选择--");
            if($rows){
                foreach($rows as $row){
                    $ar[strtolower(substr($row['abbreviation'],0,1))][$row['id']]=$row['name'];
                }
            }
        }
        return $ar;
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
        //var_dump($ar);
    	return $ar;
    }
}


    