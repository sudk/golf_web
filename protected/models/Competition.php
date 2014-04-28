<?php
/**
 * --请填写模块名称--
 *寄卖商品模型
 * @author #guohao <sudk@trunkbow.com>#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class Competition extends CActiveRecord {

    const PAY_TYPE_PREPAY = '0';
    CONST PAY_TYPE_PAY = '1';

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'g_competition';
    }

    public function rules(){
        return array(
            array('id,agent_id,name,desc,fee,start_date,end_date,plan,fee_include,fee_not_include,record_time,fee_type,creatorid', 'safe', 'on' => 'create'),
            array('id,agent_id,name,desc,fee,start_date,end_date,plan,fee_include,fee_not_include,record_time,fee_type,creatorid', 'safe', 'on' => 'modify'),
         );
    }


   

    /**
     * 吃住行游购娱
     * @param type $s
     */
   public static function getType($s = null)
   {
       $rs = array(
           '0'=>'预付',
           '1'=>'现付',
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

        
        if ($args['city'] != ''){
            $condition.=' AND g_court.city = :city';
            $params['city'] = $args['city'];
        }

        if ($args['name'] != ''){
            $condition.=' AND g_competition.name like :name';
            $params['name'] = "%".$args['name']."%";
        }
        
        if ($args['court_id'] != ''){
            $condition.=' AND g_competition.court_id = :court_id';
            $params['court_id'] = $args['court_id'];
        }
        
        if ($args['agent_id'] != ''){
            $condition.=' AND g_competition.agent_id = :agent_id';
            $params['agent_id'] = $args['agent_id'];
        }
        
        
        //$total_num = CourtFacilities::model()->count($condition, $params); //总记录数
        $total_num = Yii::app()->db->createCommand()
            ->select("count(1)")
            ->from("g_competition")
            ->leftJoin("g_court","g_court.court_id=g_competition.court_id")
            ->leftJoin("g_agent","g_agent.id=g_competition.agent_id")
            ->where($condition,$params)
            ->queryScalar();
        
    	
        $order = 'record_time  DESC';

        //$rows = CourtFacilities::model()->findAll($criteria);
        $rows=Yii::app()->db->createCommand()
            ->select("g_competition.*,g_court.name court_name,g_agent.agent_name")
            ->from("g_competition")
            ->leftJoin("g_court","g_court.court_id=g_competition.court_id")
            ->leftJoin("g_agent","g_agent.id=g_competition.agent_id")
            ->where($condition,$params)
            ->order($order)
            ->limit($pageSize)
            ->offset($page * $pageSize)
            ->queryAll();

        $rs['status'] = 0;
        $rs['desc'] = '成功';
        $rs['page_num'] = ($page + 1);
        $rs['total_num'] = $total_num;
        $rs['total_page'] = ceil($rs['total_num'] / $pageSize);
        $rs['num_of_page'] = $pageSize;
        $rs['rows'] = $rows;

        return $rs;
    }


    public static function Info($competition_id) {

        $condition = ' 1=1 ';
        $params = array();


        if ($competition_id != ''){
            $condition.=' AND g_competition.id = :id';
            $params['id'] =$competition_id;
        }else{
            return false;
        }

        //$rows = CourtFacilities::model()->findAll($criteria);
        $row=Yii::app()->db->createCommand()
            ->select("g_competition.*,g_court.name court_name,g_agent.agent_name")
            ->from("g_competition")
            ->leftJoin("g_court","g_court.court_id=g_competition.court_id")
            ->leftJoin("g_agent","g_agent.id=g_competition.agent_id")
            ->where($condition,$params)
            ->queryRow();
        if($row){
            $row['imgs']=Img::GetImgs($competition_id,Img::TYPE_COMPETITION);
        }
        return $row;

    }
    
    
    
    
}


    