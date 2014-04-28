<?php

/**
 * 特约商品推荐
 *
 * @author guohao
 */
class GoodsController extends AuthBaseController
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
        $t->url = 'index.php?r=service/goods/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('序号', '30', '');
        $t->set_header('标题', '60', '');
        $t->set_header('价格', '60', '');
        
        $t->set_header('所在城市', '80', '');
        $t->set_header('发布时间', '80', '');
        $t->set_header('状态', '80', '');
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

        if($args['title']=='标题')
        {
            $args['title'] = "";
        }
        

        $t = $this->genDataGrid();
        $this->saveUrl();

        $list = Flea::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 保存查询链接
     */
    private function saveUrl()
    {
        $a = Yii::app()->session['list_url'];
        $a['rpt/school'] = str_replace("r=service/goods/grid", "r=service/goods/list", $_SERVER["QUERY_STRING"]);
        Yii::app()->session['list_url'] = $a;
    }

    /**
     * 列表
     */
    public function actionList()
    {
        $this->render('list');
    }
    
    
    public function actionAudit()
    {
        $id = trim($_POST['id']);
        //var_dump($id);
        $rs = Flea::audit($id);
        
        //var_dump($rs);
        //exit;
        if($rs==true)
        {
            $msg = array(
                'status'=>0,
                'msg'=>'审核成功'
            );
        }else{
            $msg = array(
                'status'=>-1,
                'msg'=>'审核失败，请重新尝试'
            );
        }
        
        print_r(json_encode($msg));exit;
    }
    
    
    public function actionDetail()
    {
        $id = trim($_GET['id']);
        
        $model = Flea::model()->findByPk($id);
        
        $this->render('detail',array('model'=>$model));
    }
    
    
    
    public function actionDel()
    {
        $id = trim($_POST['id']);
        
        $rs = Flea::model()->deleteByPk($id);
        if($rs)
        {
            echo  json_encode(array('status'=>0));exit;
        }
        
        echo  json_encode(array('status'=>-1));exit;
    }

}