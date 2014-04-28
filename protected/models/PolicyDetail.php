<?php
/**
 * --请填写模块名称--
 *寄卖商品模型
 * @author #guohao <sudk@trunkbow.com>#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class PolicyDetail extends CActiveRecord {

    const STATUS_NORMAL = '0';
    const STATUS_DISABLE = '1';

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'g_policy_detail';
    }

    public function rules(){
        return array(
           
         );
    }

   
   
   public static function getStatus($s = null)
   {
       $rs = array(
           self::STATUS_NORMAL=>'正常预订',
           self::STATUS_DISABLE=>'禁止预订',
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

        
        if ($args['order'] != ''){
            $condition.=' AND order = :order';
            $params['facilite_name'] = $args['order'];
        }
        
        
        if ($args['type'] != ''){
            $condition.=' AND type=:type';
            $params['type'] = $args['type'];
        }
        
        if ($args['status'] != ''){
            $condition.=' AND status=:status';
            $params['status'] = $args['status'];
        }
        
        
        $total_num = Adv::model()->count($condition, $params); //总记录数

        $criteria = new CDbCriteria();
        
    	
        $criteria->order = 'record_time  DESC';
        

        $criteria->condition = $condition;
        $criteria->params = $params;

        $pages = new CPagination($total_num);
        $pages->pageSize = $pageSize;
        $pages->setCurrentPage($page);
        $pages->applyLimit($criteria);

        $rows = Adv::model()->findAll($criteria);

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


    