<?php

/**
 * 学校报表
 *
 * @author sudk
 */
class InboxController extends AuthBaseController
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
        $t->url = 'index.php?r=msg/inbox/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('序号', '30', '');
        $t->set_header('标题', '180', '');
        $t->set_header('类型', '60', '');
        $t->set_header('发件人', '60', '');
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
            $args['startdate']=date("Y-m-d",strtotime('-7 days'));
        }

        if(!$args['enddate']){
            $args['enddate']=date("Y-m-d");
        }
        $args['listenerid']=Yii::app()->user->id;

        $t = $this->genDataGrid();

        $list = MsgListener::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 列表
     */
    public function actionList()
    {
        $this->render('list');
    }

    public function actionSetReaded(){
        $msgid=$_POST['msgid'];
        $rs=MsgListener::SetReaded($msgid,Yii::app()->user->id);
        $msg['status']=$rs;
        print_r(json_encode($msg));
    }
}