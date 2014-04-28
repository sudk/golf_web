<?php

/**
 * 赛事
 *
 * @author guohao
 */
class CompetitionController extends AuthBaseController
{

    public $defaultAction = 'list';
    public $gridId = 'list';
    public $pageSize = 20;

    /**
     * 表头
     * @return SimpleGrid
     */
    private function genDataGrid()
    {
        $t = new SimpleGrid($this->gridId);
        $t->url = 'index.php?r=service/competition/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('序号', '30', '');
        $t->set_header('赛事名称', '120', '');
        $t->set_header('所在球场', '100', '');
        $t->set_header('费用', '60', '');
        $t->set_header('赛事时间', '100', '');
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

        if($args['name'] == "赛事名称"){
            $args['name'] = "";
        }
        

        $t = $this->genDataGrid();
        $this->saveUrl();

        $list = Competition::queryList($page, $this->pageSize, $args);
        //var_dump($list);
        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 保存查询链接
     */
    private function saveUrl()
    {
        $a = Yii::app()->session['list_url'];
        $a['rpt/school'] = str_replace("r=service/competition/grid", "r=service/competition/list", $_SERVER["QUERY_STRING"]);
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
        $cnt=  Competition::model()->count("name='".trim($name)."'");
            //print_r($operator);
        if($cnt > 0){
            return false;
        }else{
            return true;
        }
    }
    public function actionNew(){
        $model=new Competition('create');
        if($_POST['Competition']){
            $model->attributes=$_POST['Competition'];
            $model->court_id = $_POST['Competition']['court_id'];
            $model->fee = intval($_POST['Competition']['fee'])*100;
            //先判断name是否重复
            if(!$this->checkName($_POST['Competition']['name']))
            {
                $msg['msg']="添加失败！赛事名称重复";
                $msg['status']=-1;
            }else
            {
                $model->record_time=date("Y-m-d H:i:s");
                $model->creatorid = Yii::app()->user->id;
                $model->agent_id = Yii::app()->user->agent_id;
                $id = Yii::app()->user->id.date('YmdHis');
                $model->id = $id;
                //var_dump($_POST['Competition']);var_dump($model->attributes);exit;
                try{
                    $rs=$model->save();
                    if($rs){
                        $msg['msg']="添加成功！";
                        $msg['status']=1;
                        
                        $upload_img_msg = $this->uploadImgOfCompetition($_FILES['upfile'],$id);
                        $msg['msg'] .=$upload_img_msg;
                        
                        $model=new Competition('create');
                    }else{
                        $msg['msg']="添加失败！";
                        $msg['status']=-1;
                    }
                }catch (Exception $e){
                    if($e->errorInfo[0]==23000){
                        $msg['msg']="赛事编号重复！";
                        $msg['status']=-1;
                    }

                }

                
            }
        }
        $this->render("new",array('model' => $model, 'msg' => $msg));
    }
    
    /**
     * 上传赛事图片
     * @param type $files
     * @param type $relation_id
     * @return string
     */
    private  function uploadImgOfCompetition($files,$relation_id)
    {
            $succ_num = 0;
            $false_num = 0;
            $up_msg = "";
            //$files = $_FILES['upfile'];
            $msg = "";
            if(isset($files))
            {
                //var_dump($files['error']);
                foreach($files['error'] as $k=>$v)
                {
                    if($v == 0)
                    {
                        //sleep(1);
                        //可以上传
                        $rs = Img::uploadImg($files['tmp_name'][$k],$files['name'][$k],$relation_id,'3');
                        //var_dump($rs);
                        if($rs['status'] == 0)
                        {
                            $up_msg .="第".($k+1)."张图片上传成功.";
                            $succ_num++;
                            
                        }else{
                            $up_msg .= "第".($k+1)."张图片上传失败.";
                            Img::delSimpleImg($rs['url']);
                            $false_num++;
                        }
                    }  else 
                    {
                        $up_msg .= "第".($k+1)."张图片上传失败.";
                        $false_num++;
                    }
                }
                
                $msg = $succ_num>0?"上传成功。":"上传失败。";
                $msg .= $succ_num>0?"成功数量:".$succ_num.",":"";
                $msg .= $false_num>0?"失败数量:".$false_num.",":"";
                $msg .= $up_msg;
                
            }
            return $msg;
    }
    
    

    public function actionEdit(){
        $id=$_GET['id'];
        $model=  Competition::model()->findByPk($id);
        
        if($_POST['Competition']){
            
            $model->setScenario("modify");
            $model->attributes=$_POST['Competition'];
            $id = $model->id;
            $rs=$model->save();
            if($rs){
                $msg['msg']="修改成功！";
                $msg['status']=1;
                //$model=new Staff('modify');
                //如果有上传的信息，那么就先删掉原有的，用新的替换掉
                if(isset($_FILES['upfile']))
                {
                    Img::delImg($id, Img::TYPE_COMPETITION);
                    $upload_img_msg = $this->uploadImgOfCompetition($_FILES['upfile'], $id);
                    $msg['msg'] .=$upload_img_msg;
                }
                
            }else{
                $msg['msg']="修改失败！";
                $msg['status']=0;
            }
            
            
        }
       //var_dump($id);
        $this->layout = '//layouts/base';
        $this->render("edit",array('model' => $model, 'msg' => $msg,'competition_id'=>$id));
    }

 
    public function actionCheckid(){
        $id=$_GET['id'];
        $data['status']=true;
        if($id){
            $cnt=  Competition::model()->count("name='".trim($id)."'");
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
     * 赛事删除
     * 包括 
     * 赛事信息
     * 球场的图片
     */
    public function actionDel(){
        $id=$_POST['id'];
        $model = Competition::model()->findByPk($id);
        //先删除
        $rs = $model->deleteByPk($id);
        if($rs){
            //del img
            $img_rs = Img::delImg($id, Img::TYPE_COMPETITION);
            $msg['status']=true;
        }else{
            $msg['status']=false;
        }
       
        print_r(json_encode($msg));
    }
    
    
    public function actionDetail()
    {
        $info = Competition::Info($_GET['id']);
        //var_dump($info);exit;
        $this->render("detail",array('model'=>$info));
    }
    
    
    

}