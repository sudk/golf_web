<?php

/**
 * 学校报表
 *
 * @author sudk
 */
class advController extends AuthBaseController {

    public $defaultAction = 'list';
    public $gridId = 'list';
    public $pageSize = 100;

    /**
     * 表头
     * @return SimpleGrid
     */
    private function genDataGrid() {
        $t = new SimpleGrid($this->gridId);
        $t->url = 'index.php?r=service/adv/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('序号', '30', '');
        $t->set_header('广告权重', '60', '');
        $t->set_header('广告类型', '60', '');
        $t->set_header('广告图片', '130', '');
        $t->set_header('有效期', '100', '');
        $t->set_header('状态', '100', '');
        $t->set_header('操作', '100', '');
        return $t;
    }

    /**
     * 查询
     */
    public function actionGrid() {
        $page = $_GET['page'] == '' ? 0 : $_GET['page']; //当前页码
        $_GET['page'] = $_GET['page'] + 1;
        $args = $_GET['q']; //查询条件




        $t = $this->genDataGrid();
        $this->saveUrl();

        $list = Adv::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 保存查询链接
     */
    private function saveUrl() {
        $a = Yii::app()->session['list_url'];
        $a['rpt/school'] = str_replace("r=service/adv/grid", "r=service/adv/list", $_SERVER["QUERY_STRING"]);
        Yii::app()->session['list_url'] = $a;
    }

    /**
     * 列表
     */
    public function actionList() {
        $this->render('list');
    }

    public function actionNew() {
        $model = new Adv('create');
        if ($_POST['Adv']) {
            $model->attributes = $_POST['Adv'];
            $model->status = '0';
            $model->record_time = date("Y-m-d H:i:s");
            $model->creatorid = Yii::app()->user->id;

            try {
                $rs = $model->save();
                if ($rs) {
                    $msg['msg'] = "添加成功！";
                    $msg['status'] = 1;

                    $file = $_FILES['adv_img'];
                    if (is_uploaded_file($file['tmp_name'])) {
                        $upload_rs = Img::uploadImg($file['tmp_name'], $file['name'], $rs, Img::TYPE_ADV);
                        if ($upload_rs['status'] != 0) {
                            $msg['msg'] .= "广告图片上传失败。";
                        }
                        $model->link_url = $upload_rs['url'];
                        $model->save();
                    }



                    $model = new Adv('create');
                } else {
                    $msg['msg'] = "添加失败！";
                    $msg['status'] = -1;
                }
            } catch (Exception $e) {
                if ($e->errorInfo[0] == 23000) {
                    $msg['msg'] = "未知错误！";
                    $msg['status'] = -1;
                }
            }
        }
        $this->render("new", array('model' => $model, 'msg' => $msg));
    }

    public function actionEdit() {
        $id = $_GET['id'];
        $model = Adv::model()->findByPk($id);

        if ($_POST['Adv']) {

            $model->setScenario("modify");
            $model->attributes = $_POST['Adv'];
            $id = $model->id;
            $rs = $model->save();
            if ($rs) {
                $msg['msg'] = "修改成功！";
                $msg['status'] = 1;
                //$model=new Staff('modify');
                //如果有上传的信息，那么就先删掉原有的，用新的替换掉

                $file = $_FILES['adv_img'];
                if (is_uploaded_file($file['tmp_name'])) {
                    $del_rs = Img::delImg($model->id, Img::TYPE_ADV);
                    if ($del_rs['status'] != 0) {
                        $msg['msg'] .= "商户旧图片删除失败" . $del_rs['msg'];
                    }
                    $upload_rs = Img::uploadImg($file['tmp_name'], $file['name'], $model->id, Img::TYPE_ADV);
                    if ($upload_rs['status'] != 0) {
                        $msg['msg'] .= "商户图片上传失败。";
                    }

                    $model->link_url = $upload_rs['url'];
                    $model->save();
                }
            } else {
                $msg['msg'] = "修改失败！";
                $msg['status'] = 0;
            }
        }
        //var_dump($id);
        $this->layout = '//layouts/base';
        $this->render("edit", array('model' => $model, 'msg' => $msg, 'adv_id' => $id));
    }

    /**
     * 商户删除
     * 包括 
     * 商户信息
     * 球场的图片
     */
    public function actionDel() {
        $id = $_POST['id'];
        $model = Adv::model()->findByPk($id);
        //先删除
        $rs = $model->deleteByPk($id);
        if ($rs) {
            //del img
            $img_rs = Img::delImg($id, Img::TYPE_ADV);
            $msg['status'] = true;
        } else {
            $msg['status'] = false;
        }

        print_r(json_encode($msg));
    }

}