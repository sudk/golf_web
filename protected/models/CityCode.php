<?php
/**
 * --请填写模块名称--
 *
 * @author #author#
 * @copyright Copyright &copy; 2003-2009 TrunkBow Co., Inc
 */
class CityCode extends CActiveRecord {

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'district_code_full';
    }
    
    public static function getProvince()
    {
        if(isset($_SESSION['global_province_list']))
        {
            return $_SESSION['global_province_list'];
        }
        
        $sql = "select distinct(p_id) as pro_id,p_name from g_district_code_full  ";
        $rows  = Yii::app()->db->createCommand($sql)->queryAll();
        $list = array();
        if($rows)
        {
            foreach($rows as $row)
            {
                $list[$row['pro_id']] = $row['p_name'];
            }
        }
        $_SESSION['global_province_list'] = $list;
        return $list;
    }
    
    public static function getCity($p_id=null)
    {
        $sql = "select distinct(c_id) as city_id,c_name from g_district_code_full ";
        if($p_id)
        {
            $sql .= " where p_id='".$p_id."'";
        }
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $list = array();
        if($rows)
        {
            foreach($rows as $row)
            {
                $list[$row['city_id']] = $row['c_name'];
            }
        }
        
        return $list;
    }
}


    