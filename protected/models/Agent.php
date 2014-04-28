<?php
/**
 * --请填写模块名称--
 *代理商模型
 * @author #guohao <sudk@trunkbow.com>#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class Agent extends CActiveRecord {

    const STATUS_NORMAL=0;//正常
    const STATUS_DISABLE=1;//禁用

   

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'g_agent';
    }

    public function rules(){
        return array(
             //安全性
            array('agent_name,phone,contactor,extra', 'safe', 'on' => 'create'),
            array('agent_name,phone,contactor,extra,status', 'safe', 'on' => 'modify'),

            //array('password', 'compare', 'compareAttribute'=>'passwordc', 'on'=>'create,modify'),
         );
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
        if ($args['agent_name'] != ''){
            $condition.=' AND agent_name like :agent_name';
            $params['agent_name'] = "%".$args['agent_name']."%";
        }
        if ($args['phone'] != ''){
            $condition.= ' AND phone=:phone';
            $params['phone'] = $args['phone'];
        }
        
        if ($args['status'] != ''){
            $condition.=' AND status=:status';
            $params['status'] = $args['status'];
        }
        $total_num = Agent::model()->count($condition, $params); //总记录数

        $criteria = new CDbCriteria();
        
    	
        $criteria->order = 'record_time  DESC';
        

        $criteria->condition = $condition;
        $criteria->params = $params;

        $pages = new CPagination($total_num);
        $pages->pageSize = $pageSize;
        $pages->setCurrentPage($page);
        $pages->applyLimit($criteria);

        $rows = Agent::model()->findAll($criteria);

        $rs['status'] = 0;
        $rs['desc'] = '成功';
        $rs['page_num'] = ($pages->currentPage + 1);
        $rs['total_num'] = $total_num;
        $rs['total_page'] = ceil($rs['total_num'] / $rs['page_num']);
        $rs['num_of_page'] = $pages->pageSize;
        $rs['rows'] = $rows;

        return $rs;
    }


    public static function getAgentInfo($agent_id)
    {
        if(!$agent_id)
        {
            return false;
        }
        
        $info = Agent::model()->findByPk($agent_id);
        return $info;
    }
    
    
    public static function getAgentList()
    {
        $rows = Agent::model()->findAll();
        //var_dump($rows);
        $data = array();
        if($rows)
        {
            foreach($rows as $row)
            {
                $data[$row['id']] = $row['agent_name'];
            }
        }
        
        return $data;
    }
    
    
    
    
}


    