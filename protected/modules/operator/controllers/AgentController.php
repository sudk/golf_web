<?php

/**
 *
 *
 * @author sudk
 */
class AgentController extends AuthBaseController
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
        $t->url = 'index.php?r=operator/agent/grid';
        $t->updateDom = 'datagrid';
        
        $t->set_header('代理商名称', '100', '');
        $t->set_header('联系人', '70', '');
        $t->set_header('电话', '70', '');
        $t->set_header('佣金', '70', '');
        $t->set_header('状态', '50', '');
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
        
        if($args['agent_name'] == "代理商名称")
        {
            $args['agent_name'] = "";
        }
        if($args['phone'] == "联系电话")
        {
            $args['phone'] = "";
        }
        

        $t = $this->genDataGrid();

        $list = Agent::queryList($page, $this->pageSize, $args);

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
        $model=new Agent('create');
        if($_POST['Agent']){
            $model->attributes=$_POST['Agent'];
            
            $model->record_time=date("Y-m-d H:i:s");
            
            try{
                $rs=$model->save();
                if($rs){
                    $msg['msg']="添加成功！";
                    $msg['status']=1;
                    $model=new Agent('create');
                }else{
                    $msg['msg']="添加失败！";
                    $msg['status']=-1;
                }
            }catch (Exception $e){
                if($e->errorInfo[0]==23000){
                    $msg['msg']="未知错误！";
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
        $model=Agent::model()->findByPk($id);
        if($_POST['Agent']){
            
            $model->setScenario("modify");
            $model->attributes=$_POST['Agent'];
            
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
        
        $this->layout = '//layouts/base';
        $this->render("edit",array('model' => $model, 'msg' => $msg));
    }

   
    public function actionCheckAgentName(){
        $id=$_GET['id'];
        $data['status']=true;
        if($id){
            $staff=Agent::model()->find(array('agent_name'=>trim($id)));
            //print_r($Agent);
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
        
        //判断当前代理商有没有操作员，有没有产品发布
        $operator_cnt = Operator::model()->count("agent_id='".$id."'");
        if($operator_cnt > 0)
        {
            $msg['status'] = false;
            $msg['msg'] = "代理商有操作员没有删除，请先删除操作员";
            print_r(json_encode($msg));
            exit;
        }
        
        $policy_cnt = Policy::model()->count("agent_id='".$id."'");
        if($policy_cnt > 0)
        {
            $msg['status'] = false;
            $msg['msg'] = "代理商有发布的代理信息没有删除，请先删除代理信息";
            print_r(json_encode($msg));
            exit;
        }
        
        $rs=Agent::model()->deleteByPk($id);
        if($rs){
            $msg['status']=true;
        }else{
            $msg['status']=false;
        }
        print_r(json_encode($msg));
    }
    


}