<?php
/**
 * --请填写模块名称--
 *
 * @author #author#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class Auth extends CActiveRecord {
    public $role;
    public $task;
    public $list;
    public $name;
    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'g_auth';
    }

    public function rules(){
        return array(
             //安全性
            array('operator_id,auth_id,authtype', 'safe', 'on' => 'create'),
            array('operator_id,auth_id,authtype', 'safe', 'on' => 'modify'),
         );

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

        $sql = 'DELETE FROM authitem WHERE authitemid=:authitemid';
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

        $condition = '';
        $params = array();

        if ($args['operator_id'] != ''){
            $condition.= ( $condition == '') ? ' operator_id=:operator_id' : ' AND operator_id=:operator_id';
            $params['operator_id'] = $args['operator_id'];
        }
        if ($args['auth_id'] != ''){
            $condition.= ( $condition == '') ? ' auth_id=:auth_id' : ' AND auth_id=:auth_id';
            $params['auth_id'] = $args['auth_id'];
        }
        if ($args['authtype'] != ''){
            $condition.= ( $condition == '') ? ' authtype=:authtype' : ' AND authtype=:authtype';
            $params['authtype'] = $args['authtype'];
        }

        
        $total_num = Auth::model()->count($condition, $params); //总记录数

        $criteria = new CDbCriteria();
        
    	if($_REQUEST['q_order']==''){
            $criteria->order = '';
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

        $rows = Auth::model()->findAll($criteria);

        $rs['status'] = 0;
        $rs['desc'] = '成功';
        $rs['page_num'] = ($pages->currentPage + 1);
        $rs['total_num'] = $total_num;
        $rs['total_page'] = ceil($rs['total_num'] / $rs['page_num']);
        $rs['num_of_page'] = $pages->pageSize;
        $rs['rows'] = $rows;

        return $rs;
    }
    //操作权限设置
    public static function GetAuth($operator_id){
        $rows = Yii::app()->db->createCommand()
            ->select("auth_id")
            ->from("g_auth")
            ->where("operator_id='{$operator_id}'")
            ->queryAll();
        $ar=array();
        if($rows){
            foreach($rows as $row){
               $ar[]=$row['auth_id'];
            }
        }else{
            //$ar[]="default";
        }

        $ar[]="default";//默认权限
        $ar[] = "msg";
        return $ar;
    }
    
    //商户操作权限
    public static function GetMchtauth(){
    	$ar = array();
    	$ar[] = 'mchtinfo';
    	$ar[]="normaltask";//默认权限
    	return $ar;
    }
    //数据权限的设置
    public static function _GetData($auths){
        $data=false;
        foreach($auths as $auth){
            if($auth=='smanager'){  //超级管理员
                $data['auth']='smanager';
                break;
            }
            if($auth=='riskc_m'&& $data['auth']!='smanager'){
                $data['auth']='riskc_m';     //风险管理员
            }
            if($auth=='custom_m'&& $data['auth']!='smanager'&& $data['auth']!='riskc_m'){
                $data['auth']='custom_m';    //客户经理
                $data['managerid']=Yii::app()->user->id;
            }
            if($auth=='maintain_nor'&& $data['auth']!='smanager'&& $data['auth']!='riskc_m'){
                $data['auth']='maintain_nor';    //终端维护人员
                $data['maintainid']=Yii::app()->user->id;
            }
        }
        if(!$data){
            $data['auth']='default';//默认数据权限
            $data['managerid']=Yii::app()->user->id;
        }
        return $data;
    }
    //数据权限的设置
    public static function GetData($auths){
        $role=require(dirname(__FILE__).'/../data/role.php');
        $data=false;
        $data_range=100;
        foreach($auths as $auth){
            if(isset($role[$auth])){
                $role_data=$role[$auth]['data'];
            }else{
                continue;
            }
            if($role_data<$data_range){
                $data['auth']=array();
                $data['auth'][$auth]=true;
            }elseif($role_data==$data_range){
                $data['auth'][$auth]=true;
            }
            $data_range=$role_data;
        }
        if($data==false){
            $data['auth']['default']=true;//默认数据权限
            $data['auth']['msg']=true;//默认数据权限
        }
        return $data;
    }
    public static function GetByCd($condition,$params=array(),$order='auth_id DESC'){
        return Yii::app()->db->createCommand()
            ->select("*")
            ->from("auth")
            ->where($condition,$params)
            ->order($order)
            ->queryAll();
    }
}


    