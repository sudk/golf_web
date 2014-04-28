<?php

/**
 * 学校报表
 *
 * @author sudk
 */
class RouteController extends AuthBaseController
{

    public $defaultAction = 'list';
    public $gridId = 'list';
    public $pageSize = 100;

    /**
     * 表头
     * @return SimpleGrid
     */
    private function genDataGrid()
    {
        $t = new SimpleGrid($this->gridId);
        $t->url = 'index.php?r=service/route/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('序号', '30', '');
        $t->set_header('行程名称', '100', '');
        $t->set_header('支付方式', '100', '');
        $t->set_header('开始日期', '230', '');
        $t->set_header('结束日期', '100', '');
        $t->set_header('操作', '80', '');
        return $t;
    }

    /**
     * 查询
     */
    public function actionGrid()
    {
        $page = $_GET['page'] == '' ? 0 : $_GET['page']; //当前页码
        $_GET['page']=$_GET['page']+1;
        $args = $_GET['q']; //查询条件


        if ($_REQUEST['q_value'])
        {
            $args[$_REQUEST['q_by']] = $_REQUEST['q_value'];
        }
        
        if($args['trip_name'] == "套餐名称"){
            $args['trip_name'] = "";
        }

        
        $t = $this->genDataGrid();
        $this->saveUrl();

        $list = Trip::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 保存查询链接
     */
    private function saveUrl()
    {
        $a = Yii::app()->session['list_url'];
        $a['rpt/school'] = str_replace("r=service/route/grid", "r=service/route/list", $_SERVER["QUERY_STRING"]);
        Yii::app()->session['list_url'] = $a;
    }

    /**
     * 列表
     */
    public function actionList()
    {
        $this->render('list');
    }

    
    public function actionNew() {
        $model = new Trip('create');
        if ($_POST['Trip']) {
            $model->attributes = $_POST['Trip'];
            $model->agent_id = '1';//Yii::app()->user->agent_id;
            $model->record_time = date("Y-m-d H:i:s");
            $model->creatorid = Yii::app()->user->id;
            
            $model->trip_name = $_POST['Trip']['trip_name'];
            $model->court_id = $_POST['Trip']['court_id'];
            $model->city = $_POST['Trip']['city'];
            $model->normal_price = $_POST['Trip']['normal_price'];
            $model->holiday_price = $_POST['Trip']['holiday_price'];
            $model->other_price = $_POST['Trip']['other_price'];
            $model->pay_type = $_POST['Trip']['pay_type'];
            $model->is_check = $_POST['Trip']['is_check'];
            $model->start_date = $_POST['Trip']['start_date'];
            $model->end_date = $_POST['Trip']['end_date'];
            $model->desc = html_entity_decode($_POST['Trip']['desc']);
            $model->id = date('YmdHis').rand(100000,999999);
            //var_dump($_POST['Trip']);var_dump($model->attributes);exit;
            try {
                $rs = $model->save();
                if ($rs) {
                    $msg['msg'] = "添加成功！";
                    $msg['status'] = 1;

                    $file = $_FILES['trip_img'];
                    if (is_uploaded_file($file['tmp_name'])) {
                        $upload_rs = Img::uploadImg($file['tmp_name'], $file['name'], $rs, Img::TYPE_TRIP);
                        if ($upload_rs['status'] != 0) {
                            $msg['msg'] .= "行程图片上传失败。";
                        }
                        
                    }



                    $model = new Trip('create');
                } else {
                    $msg['msg'] = "添加失败！";
                    $msg['status'] = -1;
                }
            } catch (Exception $e) {
                if ($e->errorInfo[0] == 23000) {
                    $msg['msg'] = "未知错误！";
                    $msg['status'] = -1;
                }
            }
        }
        $this->render("new", array('model' => $model, 'msg' => $msg));
    }

    public function actionEdit() {
        $id = $_GET['id'];
        $model = Trip::model()->findByPk($id);

        
        if ($_POST['Trip']) {

            $model->setScenario("modify");
            $model->attributes = $_POST['Trip'];
            
            $model->trip_name = $_POST['Trip']['trip_name'];
            $model->court_id = $_POST['Trip']['court_id'];
            $model->city = $_POST['Trip']['city'];
            $model->normal_price = $_POST['Trip']['normal_price'];
            $model->holiday_price = $_POST['Trip']['holiday_price'];
            $model->other_price = $_POST['Trip']['other_price'];
            $model->pay_type = $_POST['Trip']['pay_type'];
            $model->is_check = $_POST['Trip']['is_check'];
            $model->start_date = $_POST['Trip']['start_date'];
            $model->end_date = $_POST['Trip']['end_date'];
            $model->desc = html_entity_decode($_POST['Trip']['desc']);
            
            $id = $model->id;
            $rs = $model->save();
            if ($rs) {
                $msg['msg'] = "修改成功！";
                $msg['status'] = 1;
                //$model=new Staff('modify');
                //如果有上传的信息，那么就先删掉原有的，用新的替换掉

                $file = $_FILES['trip_img'];
                if (is_uploaded_file($file['tmp_name'])) {
                    $del_rs = Img::delImg($model->id, Img::TYPE_TRIP);
                    if ($del_rs['status'] != 0) {
                        $msg['msg'] .= "行程旧图片删除失败" . $del_rs['msg'];
                    }
                    $upload_rs = Img::uploadImg($file['tmp_name'], $file['name'], $model->id, Img::TYPE_TRIP);
                    if ($upload_rs['status'] != 0) {
                        $msg['msg'] .= "行程图片上传失败。";
                    }

                }
            } else {
                $msg['msg'] = "修改失败！";
                $msg['status'] = 0;
            }
        }else{
            $city = $model->city;
            $province = substr($city,0,2)."0000";
            $model->province = $province;
        }
        //var_dump($id);
        $this->layout = '//layouts/base';
        $this->render("edit", array('model' => $model, 'msg' => $msg, 'Trip_id' => $id));
    }

    /**
     * 商户删除
     * 包括 
     * 行程信息
     * 行程的图片
     */
    public function actionDel() {
        $id = $_POST['id'];
        $model = Trip::model()->findByPk($id);
        //先删除
        $rs = $model->deleteByPk($id);
        if ($rs) {
            //del img
            $img_rs = Img::delImg($id, Img::TYPE_TRIP);
            $msg['status'] = true;
        } else {
            $msg['status'] = false;
        }

        print_r(json_encode($msg));
    }

    
    public function actionCheckId()
    {
        
        $id=$_POST['id'];
        $data['status']=true;
        if($id){
            $cnt=Court::model()->count("trip_name='".trim($id)."'");
            //print_r($operator);
            if($cnt > 0){
                $data['msg']=2;
            }else{
                $data['msg']=0;
            }
        }else{
            $data['status']=false;
        }
        print_r(json_encode($data));
    }
    
    
    public function actionDetail()
    {
        $id = trim($_GET['id']);
        
        $model = Trip::model()->findByPk($id);
        
        $this->render('detail',array('model'=>$model));
    }
    

}