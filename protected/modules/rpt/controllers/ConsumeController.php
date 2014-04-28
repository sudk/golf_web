<?php

/**
 * 消费记录报表
 *
 * @author guohao
 */
class ConsumeController extends AuthBaseController
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
        $t->url = 'index.php?r=rpt/consume/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('序号', '30', '');
        $t->set_header('交易类型', '60', '');
        $t->set_header('流水号', '100', '');
        $t->set_header('交易金额', '60', '');
        $t->set_header('关联流水号', '100', '');
        $t->set_header('客户编号', '80', '');
        $t->set_header('交易状态', '80', '');
        $t->set_header('记录时间', '100', '');
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
            $args['startdate']=date("Y-m-d");
        }

        if(!$args['enddate']){
            $args['enddate']=date("Y-m-d");
        }
        
        if($args['user_isdn'] == '用户手机号'){
            $args['user_isdn'] = "";
        }
        //print_r($args);
        $t = $this->genDataGrid();
        $this->saveUrl();

        $list = TransRecord::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 保存查询链接
     */
    private function saveUrl()
    {
        $a = Yii::app()->session['list_url'];
        $a['rpt/school'] = str_replace("r=rpt/consume/grid", "r=rpt/consume/list", $_SERVER["QUERY_STRING"]);
        Yii::app()->session['list_url'] = $a;
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
        $recordtime= $_POST['recordtime'];
        $request =  SystemlogReq::GetReqByPk($id,$recordtime);
        $msg['status'] = true;
        if ($request) {
            $request=json_decode($request);
            //print_r($request);
            //$str=self::toStr($request);
            //$msg['detail']=$model;
            $msg['detail'] = $request;
        } else {
            $msg['status'] = false;
            $msg['detail'] = "获取操作明细失败！";
        }
        print_r(json_encode($msg));
    }

    private function toStr($request){

        try{
            foreach($request as $k => $v){
                try{
                    $str.=$k.":".$v."<br>";
                }catch (Exception $e){
                    $str.=self::toStr($v);
                }
            }
        }catch (Exception $e){
            print_r($e);
        }
        return $str;
    }

}