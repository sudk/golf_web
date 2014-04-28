<?php

/**
 *
 *
 * @author sudk
 */
class OperatorController extends AuthBaseController
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
        $t->url = 'index.php?r=operator/operator/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('序号', '30', '');
        $t->set_header('类型', '60', '');
        $t->set_header('账号', '60', '','id');
        $t->set_header('姓名', '40', '');
        $t->set_header('电话', '60', '');
        $t->set_header('职称', '60', '');
        $t->set_header('全拼', '60', '','abbreviation');
        $t->set_header('状态', '30', '');
        $t->set_header('记录时间', '70', '');
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

        $t = $this->genDataGrid();

        $list = Operator::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 列表
     */
    public function actionList()
    {
        $this->render('list');
    }

    public function actionNew(){
        $model=new Operator('create');
        if($_POST['Operator']){
            $model->attributes=$_POST['Operator'];
            $model->creator=Yii::app()->user->id;
            $model->record_time=date("Y-m-d H:i:s");
            $model->remark=htmlspecialchars($_POST['Operator']['remark']);
            if(!trim($model->abbreviation)){//姓名拼音
               $model->abbreviation=Utils::Pinyin($model->staffname);
            }
            $model->password=crypt($model->password);
            try{
                $rs=$model->save();
                if($rs){
                    $msg['msg']="添加成功！";
                    $msg['status']=1;
                    $model=new Operator('create');
                }else{
                    $msg['msg']="添加失败！";
                    $msg['status']=-1;
                }
            }catch (Exception $e){
                if($e->errorInfo[0]==23000){
                    $msg['msg']="登陆账号重复！";
                    $msg['status']=-1;
                }
                $model->password="";
                $model->passwordc="";
            }
        }
        $this->render("new",array('model' => $model, 'msg' => $msg));
    }

    public function actionEdit(){
        $id=$_GET['id'];
        $model=Operator::model()->findByPk($id);
        if($_POST['Operator']){
            $p=$model->password;
            $model->setScenario("modify");
            $model->attributes=$_POST['Operator'];
            $model->remark=htmlspecialchars($_POST['Operator']['remark']);
            if(!trim($model->abbreviation)){//姓名拼音
                $model->abbreviation=Utils::Pinyin($model->name);
            }
            if(trim($model->password)){
               $model->password=crypt($model->password);
            }else{
                $model->password=$p;//为空则不修改原密码。
            }
            $rs=$model->save();
            if($rs){
                $msg['msg']="修改成功！";
                $msg['status']=1;
                //$model=new Staff('modify');
            }else{
                $msg['msg']="修改失败！";
                $msg['status']=0;
            }

        }
        $model->password="";
        $model->passwordc="";
        $this->layout = '//layouts/base';
        $this->render("edit",array('model' => $model, 'msg' => $msg));
    }

    public function actionEditpri(){
        $id=Yii::app()->user->id;
        $model=Operator::model()->findByPk($id);
        if($_POST['Operator']){
            $p=$model->password;
            $model->setScenario("modify");
            $model->attributes=$_POST['Operator'];
            $model->remark=htmlspecialchars($_POST['Operator']['remark']);
            if(!trim($model->abbreviation)){//姓名拼音
                $model->abbreviation=Utils::Pinyin($model->staffname);
            }
            if(trim($model->password)){
                $model->password=crypt($model->password);
            }else{
                $model->password=$p;//为空则不修改原密码。
            }
            $rs=$model->save();
            if($rs){
                $msg['msg']="修改成功！";
                $msg['status']=1;
                //$model=new Staff('modify');
            }else{
                $msg['msg']="修改失败！";
                $msg['status']=0;
            }

        }
        $model->password="";
        $model->passwordc="";
        $this->layout = '//layouts/base';
        $this->render("editpri",array('model' => $model, 'msg' => $msg));
    }
    public function actionCheckid(){
        $id=$_GET['id'];
        $data['status']=true;
        if($id){
            $staff=Operator::model()->findByPk($id);
            //print_r($operator);
            if($staff){
                $data['msg']=2;
            }else{
                $data['msg']=0;
            }
        }else{
            $data['status']=false;
        }
        print_r(json_encode($data));
    }

    public function actionCheckloginid(){
    	$id=$_GET['id'];
    	$data['status']=true;
    	if($id){
    		$staff=Operator::model()->findByAttributes(array('id'=>$id));
    		//print_r($operator);
    		if($staff){
    			$data['msg']=2;
    		}else{
    			$data['msg']=0;
    		}
    	}else{
    		$data['status']=false;
    	}
    	print_r(json_encode($data));
    }
    
    public function actionDel(){
        $id=$_POST['id'];
        $rs=Operator::model()->deleteByPk($id);
        if($rs){
            $msg['status']=true;
        }else{
            $msg['status']=false;
        }
        print_r(json_encode($msg));
    }
    public function actionDetail()
    {
        $id = $_POST['id'];
        $model =  Yii::app()->db->createCommand()
            ->select("*")
            ->from("g_operator st")
            ->where("st.id='{$id}'")
            ->queryRow();
        $msg['status'] = true;
        if ($model) {
            $detail=array(
                'E-Mail'=>$model['email'],
                'QQ'=>$model['qq'],
                '创建人'=>$model['creator'],
                '备注'=>$model['remark'],
            );
            if($model['type'] == Operator::TYPE_AGENT)
            {
                $agent_info = Agent::getAgentInfo($model['agent_id']);
                $detail['代理商名称'] = $agent_info['agent_name'];
            }
            $msg['detail']=Utils::MakeDetailTable($detail);
        } else {
            $msg['status'] = false;
            $msg['detail'] = "获取人员信息失败！";
        }
        print_r(json_encode($msg));
    }



}