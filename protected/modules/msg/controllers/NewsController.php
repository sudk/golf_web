<?php

/**
 * 学校报表
 *
 * @author sudk
 */
class NewsController extends AuthBaseController
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
        $t->url = 'index.php?r=msg/outbox/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('序号', '30', '');
        $t->set_header('标题', '180', '');
        $t->set_header('类型', '60', '');
        $t->set_header('发布时间', '80', '');
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

        if(!$args['startdate']){
            $args['startdate']=date("Y-m-d",strtotime("-7 days"));
        }

        if(!$args['enddate']){
            $args['enddate']=date("Y-m-d");
        }

        $t = $this->genDataGrid();
        $this->saveUrl();

        $list = MsgBox::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 保存查询链接
     */
    private function saveUrl()
    {
        $a = Yii::app()->session['list_url'];
        $a['rpt/school'] = str_replace("r=msg/outbox/grid", "r=msg/outbox/list", $_SERVER["QUERY_STRING"]);
        Yii::app()->session['list_url'] = $a;
    }

    /**
     * 列表
     */
    public function actionList()
    {
        $this->render('list');
    }

    public function actionNew(){
        $model=new MsgBox('create');
        $op_ar=Operator::GetBoxAr();
        //print_r($staff_ar);
        if($_POST['MsgBox']){
            $model->attributes=$_POST['MsgBox'];
            $title=$_POST['MsgBox']['title'];
            $content=$_POST['MsgBox']['content'];
            $type=$_POST['MsgBox']['type'];
            $creator=Yii::app()->user->id;
            $listeners=$_POST['listener'];
            $rs=MsgBox::SendMsg($title,$content,$creator,$type,$listeners);
            if($rs['status']){
                $msg['msg']=$rs['desc'];
                $msg['status']=1;
                $model=new MsgBox('create');
            }else{
                $msg['msg']=$rs['desc'];
                $msg['status']=2;
            }

        }
        $this->render("new",array('model' => $model, 'msg' => $msg,'op_ar'=>$op_ar));
    }

    public function actionDel(){
        $id=$_POST['id'];
        $rs=MsgBox::model()->deleteByPk($id);
        if($rs){
            $msg['status']=true;
        }else{
            $msg['status']=false;
        }
        print_r(json_encode($msg));
    }

    public function actionShow(){
        $id = $_REQUEST['id'];
        $model=MsgBox::model()->findByPk($id);
        if(!$model){
           $model=new MsgBox();
           $model->title='消息已被发布人删除';
            $model->recordtime='---------';
        }
        MsgListener::SetReaded($id,Yii::app()->user->id);//设置信息为已读
        $this->renderPartial("detail",array('model' => $model));
    }

    public function actionDetail()
    {
        $id = $_POST['id'];
        $msg['status'] = true;
        $rs=Yii::app()->db->createCommand()
            ->select("listener")
            ->from("msg_listener")
            ->where("msgid='{$id}'")
            ->queryAll();
        if ($rs) {
            foreach($rs as $v){
                $str.=$v['listener'].";";
            }
            $msg['detail'] = "<p>接收人：".$str."</p>";
        } else {
            $msg['status'] = false;
            $msg['detail'] = "获取明细失败！";
        }
        print_r(json_encode($msg));
    }

}