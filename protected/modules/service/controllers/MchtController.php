<?php

/**
 * 学校报表
 *
 * @author sudk
 */
class MchtController extends AuthBaseController
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
        $t->url = 'index.php?r=service/mcht/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('序号', '30', '');
        $t->set_header('商户名称', '60', '');
        $t->set_header('商户类型', '60', '');
        $t->set_header('电话', '130', '');
        $t->set_header('最近的球场', '80', '');
        $t->set_header('记录时间', '80', '');
        $t->set_header('操作', '100', '');
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

        if($args['facilite_name'] == "商户名称"){
            $args['facilite_name'] = "";
        }
        

        $t = $this->genDataGrid();
        $this->saveUrl();

        $list = CourtFacilities::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 保存查询链接
     */
    private function saveUrl()
    {
        $a = Yii::app()->session['list_url'];
        $a['rpt/school'] = str_replace("r=service/mcht/grid", "r=service/mcht/list", $_SERVER["QUERY_STRING"]);
        Yii::app()->session['list_url'] = $a;
    }

    /**
     * 列表
     */
    public function actionList()
    {
        $this->render('list');
    }
    
    
    
    private function checkName($name)
    {
        $cnt=  CourtFacilities::model()->count("facilitie_name='".trim($name)."'");
            //print_r($operator);
        if($cnt > 0){
            return false;
        }else{
            return true;
        }
    }
    public function actionNew(){
        $model=new CourtFacilities('create');
        if($_POST['CourtFacilities']){
            $model->attributes=$_POST['CourtFacilities'];
            //先判断name是否重复
            if(!$this->checkName($_POST['CourtFacilities']['facilitie_name']))
            {
                $msg['msg']="添加失败！商户名称重复";
                $msg['status']=-1;
            }else
            {
                $model->record_time=date("Y-m-d H:i:s");
                $id = Yii::app()->user->id.date('YmdHis');
                $model->id = $id;
                try{
                    $rs=$model->save();
                    if($rs){
                        $msg['msg']="添加成功！";
                        $msg['status']=1;
                        
                        $file = $_FILES['mcht_img'];
                        if(is_uploaded_file($file['tmp_name'])){
                            $upload_rs = Img::uploadImg($file['tmp_name'], $file['name'], $id, 2);
                            if($upload_rs['status']!=0)
                            {
                                $msg['msg'] .= "商户图片上传失败。";
                            }
                        }
                        
                        
                        $model=new CourtFacilities('create');
                    }else{
                        $msg['msg']="添加失败！";
                        $msg['status']=-1;
                    }
                }catch (Exception $e){
                    if($e->errorInfo[0]==23000){
                        $msg['msg']="商户编号重复！";
                        $msg['status']=-1;
                    }

                }

                
            }
        }
        $this->render("new",array('model' => $model, 'msg' => $msg));
    }

    public function actionEdit(){
        $id=$_GET['id'];
        $model=  CourtFacilities::model()->findByPk($id);
        
        if($_POST['CourtFacilities']){
            
            $model->setScenario("modify");
            $model->attributes=$_POST['CourtFacilities'];
            $id = $model->id;
            $rs=$model->save();
            if($rs){
                $msg['msg']="修改成功！";
                $msg['status']=1;
                //$model=new Staff('modify');
                //如果有上传的信息，那么就先删掉原有的，用新的替换掉
                
                $file = $_FILES['mcht_img'];
                if(is_uploaded_file($file['tmp_name'])){
                    $del_rs = Img::delImg($model->id, 2);
                    if($del_rs['status'] != 0)
                    {
                        $msg['msg'] .= "商户旧图片删除失败".$del_rs['msg'];
                    }
                    $upload_rs = Img::uploadImg($file['tmp_name'], $file['name'], $model->id, 2);
                    if($upload_rs['status']!=0)
                    {
                        $msg['msg'] .= "商户图片上传失败。";
                    }
                }
            }else{
                $msg['msg']="修改失败！";
                $msg['status']=0;
            }
            
            
        }
       //var_dump($id);
        $this->layout = '//layouts/base';
        $this->render("edit",array('model' => $model, 'msg' => $msg,'mcht_id'=>$id));
    }

 
    public function actionCheckid(){
        $id=$_GET['id'];
        $data['status']=true;
        if($id){
            $cnt=  CourtFacilities::model()->count("facilitie_name='".trim($id)."'");
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

    
  
    /**
     * 商户删除
     * 包括 
     * 商户信息
     * 球场的图片
     */
    public function actionDel(){
        $id=$_POST['id'];
        $model = CourtFacilities::model()->findByPk($id);
        //先删除
        $rs = $model->deleteByPk($id);
        if($rs){
            //del img
            $img_rs = Img::delImg($id, '2');
            $msg['status']=true;
        }else{
            $msg['status']=false;
        }
       
        print_r(json_encode($msg));
    }
    
    
    public function actionDetail()
    {
        $model = CourtFacilities::model()->findByPk(trim($_GET['id']));
        
        $this->render("detail",array('model'=>$model));
    }
    
    
    

}