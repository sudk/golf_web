<?php
/**
 * --请填写模块名称--
 *寄卖商品模型
 * @author #guohao <sudk@trunkbow.com>#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class Adv extends CActiveRecord {

    const STATUS_NORMAL = '0';
    const STATUS_DISABLE = '1';

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'g_adv';
    }

    public function rules(){
        return array(
            array('order,type,type,start_time,end_time,creatorid,link_url,record_time', 'safe', 'on' => 'create'),
            array('order,type,type,start_time,end_time,creatorid,link_url,record_time', 'safe', 'on' => 'modify'),
         );
    }


   

    /**
     * 吃住行游购娱
     * @param type $s
     */
   public static function getType($s = null)
   {
       $rs = array(
           '0'=>'全屏',
           '1'=>'横屏',
         
       );
       
       return $s ? $rs[$s] : $rs;
   }
   
   
   public static function getStatus($s = null)
   {
       $rs = array(
           self::STATUS_NORMAL=>'正常',
           self::STATUS_DISABLE=>'禁用',
       );
       
       return $s ? $rs[$s] : $rs;
   }
   
   
   public static function getOrder($s = null)
   {
       $rs = array(
           '1'=>'1',
           '2'=>'2',
           '3'=>'3',
           '4'=>'4',
           '5'=>'5',
           '6'=>'6',
           '7'=>'7',
           '8'=>'8',
           '9'=>'9',
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


    public static function Adv_list($type) {

        $rows=Yii::app()->db->createCommand()
            ->select("g_adv.id,g_adv.link_url,g_img.img_url")
            ->from("g_adv")
            ->leftJoin("g_img","g_img.type=7 and g_adv.id=g_img.relation_id")
            ->where("g_adv.type=:type and g_adv.status=0 and g_adv.start_time <= :date and g_adv.end_time >= :date",array("type"=>$type,'date'=>date("Y-m-d")))
            ->order("`order`")
            ->limit(3)
            ->queryAll();
        return $rows;

    }
    
    
    
    
    
}


    