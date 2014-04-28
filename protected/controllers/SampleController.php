<?php
/*
 * 模块编号: M1001
 */
class SampleController extends BaseController
{

    public $defaultAction = 'list';
    public $gridId = 'sample_list';
    public $pageSize = 10;
    private $_rec;

    private function genDataGrid()
    {

        $t = new SimpleGrid($this->gridId);
        $t->url = 'index.php?r=sample/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('ID', '', '','operator_id');
        $t->set_header('姓名', '', 'left','name');
        $t->set_header('分类', '', '','cate_id');
        $t->set_header('提供者', '', '');
        $t->set_header('状态', '', '');
        $t->set_header('操作', '', '');
        return $t;
    }

    /**
     * 查询
     */
    public function actionGrid()
    {
        $page = intval($_REQUEST['page']);
        $args = $_GET['q'];//查询条件

        $t = $this->genDataGrid();
        $list = Operator::queryList($page, $this->pageSize, $args); //分页
        $this->saveUrl();
        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num']));
    }

    /*
     * 保存查询链接
     */

    private function saveUrl()
    {
        $a = Yii::app()->session['list_url'];
        $a['sample'] = str_replace("r=sample/grid", "r=sample/list", $_SERVER["QUERY_STRING"]);
        Yii::app()->session['list_url'] = $a;
    }

    /**
     * 列表
     */
    public function actionList()
    {
        $this->render('list');
    }

    /**
     * 添加
     */
    public function actionNew()
    {
        $model = new Operator('create');

        $r = array();
        if (isset($_POST['Operator']))
        {
            $model->attributes = $_POST['Operator'];
            $model->operator_id = $_POST['Operator']['operator_id'];
            $model->name = $_POST['Operator']['name'];
            $model->password = $_POST['Operator']['password'];
            $model->type = 1;
            $model->status = Operator::STATUS_NORMAL;

            if ($model->validate())
            {
                if($model->save())
                	$r['message'] = '添加成功.';
                
                $this->redirect(array('list'));
            } 
            else
            {
                $r['message'] = '发生错误';
            }
        } 
        $this->render('new', array('model' => $model, 'result' => $r));
    }

    /**
     * 添加
     */
    public function actionNewdialog()
    {
        $model = new Operator('create');

        $r = array();
        if (isset($_POST['Operator']))
        {
            $model->attributes = $_POST['Operator'];
            $model->operator_id = $_POST['Operator']['operator_id'];
            $model->name = $_POST['Operator']['name'];
            $model->password = $_POST['Operator']['password'];
            $model->type = 1;
            $model->status = Operator::STATUS_NORMAL;

            if ($model->validate())
            {
                $model->save();
                $r['message'] = '添加成功.';
                $model = new Operator('create');
            } else
            {
                $r['message'] = '有错误';
            }
        } else
        {
            //$model->targets = 0;
        }
        $this->layout = '//layouts/base';
        $this->render('newdialog', array('model' => $model, 'result' => $r));
    }

    /**
     * 编辑
     */
    public function actionEdit()
    {
        $id = intval($_REQUEST['id']);
        $model = $this->loadRecord();
        $r = array();
        if (isset($_POST['Operator']))
        {
            $model->scenario = 'modify';
            $model->attributes = $_POST['Operator'];
            $model->name = $_POST['Operator']['name'];

            if ($model->validate())
            {
                $model->save();

                $r['message'] = '修改成功.';
                $r['refresh'] = true;
            } else
            {

                $r['message'] = '有错误';
            }
        }
        $this->layout = '//layouts/base';
        $this->render('edit', array('id' => $id, 'model' => $model, 'result' => $r));
    }

    /**
     * 查看
     */
    public function actionView()
    {
        $id = intval($_REQUEST['id']);
        $model = $this->loadRecord();
        $r = array();
        if (isset($_POST['Operator']))
        {
            $model->attributes = $_POST['Operator'];
            $model->html_url = $_POST['Operator']['html_url'];
            $model->flash_url = $_POST['Operator']['flash_url'];
            $model->wap_url = $_POST['Operator']['wap_url'];
            $model->poster = Yii::app()->user->id;
            $model->poster_type = 2;

            if ($model->validate())
            {

                $model->save();


                $r['message'] = '添加成功.';
            } else
            {
                $r['message'] = '有错误';
            }
        } else {
            //$model->targets = 0;
        }
        $this->render('view', array('model' => $model, 'result' => $r));
    }

    public function actionDelete()
    {
        $id = intval($_REQUEST['id']);
        //$model = new SimpleModel();
        $r = array();
        if ($_REQUEST['confirm'])
        {

            Operator::delete($id);

            $r['message'] = '删除成功.';
            $r['refresh'] = true;
        }

        $this->renderPartial('delete', array('id' => $id, 'model' => $model, 'result' => $r));
    }

    public function actionEdit2()
    {
        $this->layout = '//layouts/column2';

        $model = new Operator();
        $r = array();
        if (isset($_POST['Operator']))
        {
            $model->attributes = $_POST['Operator'];
            $model->html_url = $_POST['Operator']['html_url'];
            $model->flash_url = $_POST['Operator']['flash_url'];
            $model->wap_url = $_POST['Operator']['wap_url'];

            if ($model->validate())
            {
                $model->save();


                $r['message'] = '添加成功.' . $_POST['Operator']['flash_url'] . ',' . $model->html_url;
            } else
            {
                $r['message'] = '有错误';
            }
        } else {
            //$model->targets = 0;
        }
        $this->render('edit', array('model' => $model, 'result' => $r));
    }

    public function loadRecord($id=null)
    {
        if ($this->_rec === null)
        {
            if ($id !== null || isset($_GET['id']))
                $this->_rec = Operator::model()->findbyPk($id !== null ? $id : $_GET['id']);
            if ($this->_rec === null)
                throw new CHttpException(404, 'The requested message does not exist.');
        }
        return $this->_rec;
    }

    public function actionView1()
    {
        $this->render('view1');
    }

}