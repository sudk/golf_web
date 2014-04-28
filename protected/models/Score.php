<?php
/**
 * --请填写模块名称--
 *
 * @author #guohao 
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class Score extends CActiveRecord {

   
    

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'g_score';
    }

    public function rules(){
        return array(
          
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

        $condition = ' 1=1 ';
        $params = array();

        if ($args['court_id'] != ''){
            $condition.= ' AND court_id=:court_id';
            $params['court_id'] = $args['court_id'];
        }
        $sub_sql = "";
        if ($args['user_name'] != ''){
            $sub_sql .= $sub_sql==""?"":" AND ";
            $sub_sql.="  user_name like '%".$args['user_name']."%'";
           
        }
        if ($args['phone'] != ''){
            $sub_sql .= $sub_sql==""?"":" AND ";
            $sub_sql.="  phone = '".$args['phone']."'";
           
        }
        
        if ($args['card_no'] != ''){
            $sub_sql .= $sub_sql==""?"":" AND ";
            $sub_sql.="  card_no = '".$args['card_no']."'";
           
        }
        
        if($sub_sql != "")
        {
            $rows = User::model()->findAll($sub_sql);
            if(@count($rows) > 0)
            {
                $condition .= " AND user_id in ('";
                foreach($rows as $row)
                {
                    $condition .= $row['user_id']."','";
                }
                
                $condition  = substr($condition, 0, strlen($condition)-2);
                
                $condition .= ")";
                
            }
        }
        
        
        $total_num = Score::model()->count($condition, $params); //总记录数

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

        $rows = Score::model()->findAll($criteria);

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


    