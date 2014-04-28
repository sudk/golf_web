<?php
/**
 * --请填写模块名称--
 *寄卖商品模型
 * @author #guohao <sudk@trunkbow.com>#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class CourtFacilities extends CActiveRecord {

    

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'g_court_facilities';
    }

    public function rules(){
        return array(
            array('court_id,facilitie_name,type,feature,consumption,favourable,phone,addr,distance,record_time', 'safe', 'on' => 'create'),
            array('court_id,facilitie_name,type,feature,consumption,favourable,phone,addr,distance,record_time', 'safe', 'on' => 'modify'),
         );
    }


   

    /**
     * 吃住行游购娱
     * @param type $s
     */
   public static function getType($s = null)
   {
       $rs = array(
           '1'=>'吃',
           '2'=>'住',
           '3'=>'行',
           '4'=>'游',
           '5'=>'购',
           '6'=>'娱',
       );
       
       return $s ? $rs[$s] : $rs;
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

        
        if ($args['facilite_name'] != ''){
            $condition.=' AND facilite_name like :facilite_name';
            $params['facilite_name'] = "%".$args['facilite_name']."%";
        }
        
        
        if ($args['type'] != ''){
            $condition.=' AND type=:type';
            $params['type'] = $args['type'];
        }
        
        if ($args['court_id'] != ''){
            $condition.=' AND court_id=:court_id';
            $params['court_id'] = $args['court_id'];
        }
        
        
        //$total_num = CourtFacilities::model()->count($condition, $params); //总记录数
        $total_num = Yii::app()->db->createCommand()
            ->select("count(1)")
            ->from("g_court_facilities")
            ->where($condition,$params)
            ->queryScalar();

        $criteria = new CDbCriteria();
        
    	
        $order = 'record_time  DESC';
        

        $criteria->condition = $condition;
        $criteria->params = $params;

        $pages = new CPagination($total_num);
        $pages->pageSize = $pageSize;
        $pages->setCurrentPage($page);
        $pages->applyLimit($criteria);

        //$rows = CourtFacilities::model()->findAll($criteria);
        $rows=Yii::app()->db->createCommand()
            ->select("*")
            ->from("g_court_facilities")
            ->where($condition,$params)
            ->order($order)
            ->limit($pageSize)
            ->offset($page * $pageSize)
            ->queryAll();

        $rs['status'] = 0;
        $rs['desc'] = '成功';
        $rs['page_num'] = ($pages->currentPage + 1);
        $rs['total_num'] = $total_num;
        $rs['total_page'] = ceil($rs['total_num'] / $rs['page_num']);
        $rs['num_of_page'] = $pages->pageSize;
        $rs['rows'] = $rows;

        return $rs;
    }


    
    
    
    
    
}


    