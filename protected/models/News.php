<?php
/**
 * --请填写模块名称--
 *新闻模型
 * @author #guohao <sudk@trunkbow.com>#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class News extends CActiveRecord {

    public $imgs;
    
    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'g_news';
    }

    public function rules(){
        return array(
            array('id,title,content,creatorid,creator,record_time,status', 'safe', 'on' => 'create'),
            array('id,title,content,creatorid,creator,record_time,status', 'safe', 'on' => 'modify'),
         );
    }


   

    /**
     * 吃住行游购娱
     * @param type $s
     */
   public static function getStatus($s = null)
   {
       $rs = array(
           '0'=>'正常',
           '1'=>'取消',
       );
       
       return $s!="" ? $rs[$s] : $rs;
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

        
        if ($args['status'] != ''){
            $condition.=' AND status = :status';
            $params['status'] = $args['status'];
        }

        if ($args['title'] != ''){
            $condition.=' AND title like :title';
            $params['title'] = "%".$args['title']."%";
        }
       
        
        $total_num = News::model()->count($condition, $params); //总记录数
        
    	$criteria = new CDbCriteria();
        $order = 'record_time  DESC,status asc';
        $criteria->order = $order;
    	

        $criteria->condition = $condition;
        $criteria->params = $params;

        $pages = new CPagination($total_num);
        $pages->pageSize = $pageSize;
        $pages->setCurrentPage($page);
        $pages->applyLimit($criteria);
        

        
        $rows = News::model()->findAll($criteria);
        

        $rs['status'] = 0;
        $rs['desc'] = '成功';
        $rs['page_num'] = ($page + 1);
        $rs['total_num'] = $total_num;
        $rs['total_page'] = ceil($rs['total_num'] / $pageSize);
        $rs['num_of_page'] = $pageSize;
        $rs['rows'] = $rows;

        return $rs;
    }
    
    
    public static function Info($id) {

        $condition = ' 1=1 ';
        $params = array();


        if ($id != ''){
            $condition.=' AND id = :id';
            $params['id'] =$id;
        }else{
            return false;
        }
        
        $row = News::model()->find($condition,$params);

        
        if($row){
            $row['imgs']=Img::GetImgs($id,Img::TYPE_NEWS);
        }
        return $row;

    }
    
    
    
    
}


    