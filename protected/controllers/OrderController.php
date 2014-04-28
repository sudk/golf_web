<?php
/*
 * 订单管理
 */
class OrderController extends AuthBaseController
{

    public $defaultAction = 'list';
    public $gridId = 'list';
    public $lGridId = 'log_list';
   
    public $pageSize = 20;
    public $module_id = 'order';
    
    

    /**
     * 表头
     * @return SimpleGrid
     */
    private function genDataGrid()
    {
        $t = new SimpleGrid($this->gridId);
        $t->url = 'index.php?r=order/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('订单编号', '100', '');
        $t->set_header('订单类型', '70', '');   
        $t->set_header('下单人', '60', '');
        $t->set_header('商品名称', '100', '');
        $t->set_header('订单金额', '100', '');
        $t->set_header('支付方式', '100', '');
        $t->set_header('状态', '100', '');
        $t->set_header('下单时间', '100', '');
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
        
        if(Yii::app()->user->type == Operator::TYPE_AGENT)
        {
            $args['agent_id'] = Yii::app()->user->agent_id;
        }

        $list = Order::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 列表
     */
    public function actionList()
    {
        $this->render('list');
    }

    
    public function actionDetail()
    {
        $id = $_POST['id'];
        $model =  Yii::app()->db->createCommand()
            ->select("*")
            ->from("g_order st")
            ->where("st.order_id='{$id}'")
            ->queryRow();
            
        $court = Yii::app()->db->createCommand()
                ->select('phone')
                ->from('g_court t')
                ->where("t.court_id='{$model['relation_id']}'")
                ->queryRow();
                
        
         
        $msg['status'] = true;
        if ($model) {
            $detail=array(
                '球场电话'=>$court['phone'],
                '客户电话'=>$model['phone'],
               '打球时间'=>$model['tee_time'],
                '人数'=>$model['count'],
                '单价'=>$model['unitprice'],
                '必须支付'=>$model['had_pay'],
                '备注'=>$model['desc'],
                    
            );
            //还要把状态修改的过程展示在这里
            $msg['detail']=Utils::MakeDetailTable($detail);
        } else {
            $msg['status'] = false;
            $msg['detail'] = "获取球场信息失败！";
        }
        print_r(json_encode($msg));
    }
    
    
    public function actionEdit()
    {
        $id = trim($_GET['id']);
        
        $model=Order::model()->findByPk($id);
        
        if($_POST['Order'])
        {
            $model->attributes = $_POST['Order'];
            $model->status = $_POST['Order']['status'];
            //var_dump($model->attributes);var_dump($_POST['Order']);
            $rs = $model->save();
            if($rs){
                $msg['msg']="修改成功！";
                $msg['status']=1;
                //$model=new Staff('modify');
            }else{
                $msg['msg']="修改失败！";
                $msg['status']=0;
            }
        }else{
            $status = $model->status;
            $next_status = "";
            if($status == Order::STATUS_TOBE_CONFIRM){
                $next_status = Order::STATUS_TOBE_PAID;
            }else if($status == Order::STATUS_TOBE_PAID)
            {
                $next_status = Order::STATUS_TOBE_SUCCESS;
            }
            
            $model->status = $next_status;
        }
        $this->layout = '//layouts/base';
        $this->render("edit",array('model' => $model, 'msg' => $msg));
    }
    
    
    /**
     * 表头
     * @return SimpleGrid
     */
    private function genLDataGrid()
    {
        $t = new SimpleGrid($this->lGridId);
        $t->url = 'index.php?r=order/lgrid';
        $t->updateDom = 'datagrid';
        $t->set_header('编号', '50', '');
        $t->set_header('记录时间', '100', '');
        $t->set_header('订单编号', '100', '');
        $t->set_header('状态', '70', '');   
        $t->set_header('操作人', '60', '');
        $t->set_header('操作类型', '100', '');
        $t->set_header('流水号', '100', '');
        
        return $t;
    }

    /**
     * 查询
     */
    public function actionLGrid()
    {
        $page = $_GET['page'] == '' ? 0 : $_GET['page']; //当前页码
        $_GET['page']=$_GET['page']+1;
        $args = $_GET['q']; //查询条件


        if ($_REQUEST['q_value'])
        {
            $args[$_REQUEST['q_by']] = $_REQUEST['q_value'];
        }
        
        if(isset($_SESSION['cur_order_log']))
        {
            $args['order_id'] = $_SESSION['cur_order_log'];
        }
        //var_dump($args);
        $t = $this->genLDataGrid();

        $list = OrderLog::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_loglist', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 列表
     */
    public function actionLog()
    {
        unset($_SESSION['cur_order_log']);
        $order_id = trim($_GET['id']);
        $_SESSION['cur_order_log'] = $order_id;
        $this->render('log_list',array('order_id'=>$order_id));
    }
	

}