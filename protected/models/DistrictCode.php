<?php
/**
 * --请填写模块名称--
 *
 * @author #author#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class DistrictCode extends CActiveRecord {

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'district_code';
    }

    public function rules(){
        return array(
             //安全性
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

        if ($args['mchtid'] != ''){
            $condition.= ( $condition == '') ? ' mchtid=:mchtid' : ' AND mchtid=:mchtid';
            $params['mchtid'] = $args['mchtid'];
        }
        if ($args['posid'] != ''){
            $condition.= ( $condition == '') ? ' posid=:posid' : ' AND posid=:posid';
            $params['posid'] = $args['posid'];
        }
        if ($args['postype'] != ''){
            $condition.= ( $condition == '') ? ' postype=:postype' : ' AND postype=:postype';
            $params['postype'] = $args['postype'];
        }
        if ($args['manager'] != ''){
            $condition.= ( $condition == '') ? ' manager=:manager' : ' AND manager=:manager';
            $params['manager'] = $args['manager'];
        }
        if ($args['status'] != ''){
            $condition.= ( $condition == '') ? ' status=:status' : ' AND status=:status';
            $params['status'] = $args['status'];
        }

        //如果是客户经理数据权限
        if(Yii::app()->user->data['auth']=='custom_m'){
            $condition.= ( $condition == '') ? ' managerid=:managerid' : ' AND managerid=:managerid';
            $params['managerid'] = Yii::app()->user->data['managerid'];
        }
        
        $total_num = Posinfo::model()->count($condition, $params); //总记录数

        $criteria = new CDbCriteria();
        
    	if($_REQUEST['q_order']==''){
            $criteria->order = ' recordtime DESC';
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

        $rows = Posinfo::model()->findAll($criteria);

        $rs['status'] = 0;
        $rs['desc'] = '成功';
        $rs['page_num'] = ($pages->currentPage + 1);
        $rs['total_num'] = $total_num;
        $rs['total_page'] = ceil($rs['total_num'] / $rs['page_num']);
        $rs['num_of_page'] = $pages->pageSize;
        $rs['rows'] = $rows;

        return $rs;
    }

    /**
     * @param int $level 行政级别 1级为省级，2级为城市，3级为区。
     * @param string $code 上一级地区码
     * @param bool $per_sel 是否在返回的列表中加入“--请选择--”;
     * @return array|bool 有数据的情况下返回数组，没能数据的情况下返回false;
     */
    public static function GetDistrict($level=1,$code="",$per_sel=true){
        if($level==1){
            $condition="level = 1";
        }elseif($level==2&&$code!=""){
            $end_code=$code+10000;
            $condition="level = 2 and code > '{$code}' and code < '{$end_code}'";
        }elseif($level==3&&$code!=""){
            $end_code=$code+100;
            $condition="level = 3 and code > '{$code}' and code < '{$end_code}'";
        }else{
            return false;
        }
        $rs=DistrictCode::model()->findAll($condition);

        if($per_sel){
            $ds=array(''=>'--请选择--');
        }else{
            $ds=array();
        }

        if(count($rs)>0){
        foreach($rs as $v){
           $ds[$v['code']]=$v['name'];
        }
            return $ds;
        }else{
            return false;
        }
    }

    /**
     * @param int $level
     * @param string $code
     * @return bool
     */
    public static function GetDistrictList($level=1,$code=""){
        if($level==1){
            $condition="level = 1";
        }elseif($level==2&&$code!=""){
            $end_code=$code+10000;
            $condition="level = 2 and code > '{$code}' and code < '{$end_code}'";
        }elseif($level==3&&$code!=""){
            $end_code=$code+100;
            $condition="level = 3 and code > '{$code}' and code < '{$end_code}'";
        }else{
            return false;
        }
        $rs=Yii::app()->db->createCommand()
            ->select("code,name")
            ->from("district_code")
            ->where($condition)
            ->queryAll();
        if(count($rs)>0){
            return $rs;
        }else{
            return false;
        }
    }

    public static function GetProvince(){
        return self::GetDistrict();
    }
    public static function GetCity($p_code){
        return self::GetDistrict(2,$p_code);
    }
    public static function GetArea($c_code){
        return self::GetDistrict(3,$c_code);
    }
    public static function GetCityList($p_code){
        return self::GetDistrictList(2,$p_code);
    }
}


    