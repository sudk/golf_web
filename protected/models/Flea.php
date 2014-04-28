<?php
/**
 * --请填写模块名称--
 *寄卖商品模型
 * @author #guohao <sudk@trunkbow.com>#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class Flea extends CActiveRecord {

    const STATUS_NORMAL=0;//正常
    const STATUS_UNAUDITED=1;//待审核

   

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'g_flea';
    }

    public function rules(){
        return array(
            
         );
    }


   

    public static function  GetStatus($s = "")
    {
        $ar=array(
            self::STATUS_NORMAL=>"正常",
            self::STATUS_UNAUDITED=>"待审核",
        );
        return trim($s)!=""?$ar[$s]:$ar;
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

        
        if ($args['title'] != ''){
            $condition.=' AND title like :title';
            $params['title'] = "%".$args['title']."%";
        }
        
        
        if ($args['status'] != ''){
            $condition.=' AND status=:status';
            $params['status'] = $args['status'];
        }
        $total_num = Flea::model()->count($condition, $params); //总记录数

        $criteria = new CDbCriteria();
        
    	
        $criteria->order = 'status,record_time  DESC';
        

        $criteria->condition = $condition;
        $criteria->params = $params;

        $pages = new CPagination($total_num);
        $pages->pageSize = $pageSize;
        $pages->setCurrentPage($page);
        $pages->applyLimit($criteria);

        $rows = Flea::model()->findAll($criteria);

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
     * 审核通过
     * @param type $flea
     * @return boolean
     */
    public static function audit($flea)
    {
        if($flea==null||$flea=="")
        {
            return false;
        }
        
        $model = Flea::model()->findByPk($flea);
        
        $model->status = Flea::STATUS_NORMAL;
        $model->check_time = date('Y-m-d H:i:s');
        $model->check_id = Yii::app()->user->id;
        //var_dump($model->attributes);
        $rs = $model->save();
        
        return $rs;
    }
    
    
    
    
}


    