<?php
/*
 * 模块编号: M0403
 */
class AuthController extends BaseController
{

    public $defaultAction = 'list';
    public $gridId = 'org_list';
    public $pageSize = 200;
    private $_rec;

    /**
     * 编辑
     */
    public function actionEdit()
    {
        $model = new Auth('create');
        if (isset($_POST['Auth'])) {
            $model->attributes = $_POST['Auth'];
            $r = array();
            $code = $model->save();
            if ($code) {
                $r['message'] = '添加成功.';
                $r['success'] = true;
            } else {
                $r['message'] = $r['desc'];
                $r['success'] = false;
            }
            print_r(json_encode($r));
        } else {
            $args = $_GET['q'];
            $model->role = require(dirname(__FILE__) . '/../data/role.php');
            $model->task = require(dirname(__FILE__) . '/../data/task.php');
            $args['operator_id'] = $args['id'];
            $list = Auth::queryList(0, $this->pageSize, $args);
            $model->list = $list['rows'];
            $model->name = $args['name'];
            $model->operator_id = $args['id'];
            $this->layout = '//layouts/base';
            $this->render('edit', array('id' => $id, 'model' => $model, 'result' => $r));
        }
    }

    public function actionDelete()
    {
        $operator_id = $_POST['operator_id'];
        $auth_id = $_POST['auth_id'];
        $r = array();
        if ($_REQUEST['confirm']) {
            //$auth=new Auth();
            $rs = Auth::model()->deleteByPk(array('operator_id'=>$operator_id,'auth_id'=>$auth_id,));
            if ($rs) {
                $r['success'] = true;
            } else {
                $r['success'] = false;
            }
            print_r(json_encode($r));
        }
    }

    public function getByid($id, $authid)
    {
        $params = array("operator_id" => $id, "auth_id" => $authid);
        return Auth::model()->findByPy($params);
    }

}