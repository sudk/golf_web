<?php
/*
 * 球场管理
 */
class CourtController extends AuthBaseController
{

    public $defaultAction = 'list';
    public $gridId = 'list';
    public $picGridId = 'pic_list';
    public $cGridId = 'comment_list';
    public $pageSize = 100;
    public $module_id = 'court';
    
    

    /**
     * 表头
     * @return SimpleGrid
     */
    private function genDataGrid()
    {
        $t = new SimpleGrid($this->gridId);
        $t->url = 'index.php?r=court/grid';
        $t->updateDom = 'datagrid';
        $t->set_header('球场名称', '100', '');
        $t->set_header('球场模式', '70', '');   
        $t->set_header('球场电话', '60', '');
        $t->set_header('球场地址', '100', '');
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

        $list = Court::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_list', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }

    /**
     * 列表
     */
    public function actionList()
    {
        $this->render('list');
    }

    private function checkName($name)
    {
        $cnt=Court::model()->count("name='".trim($name)."'");
            //print_r($operator);
        if($cnt > 0){
            return false;
        }else{
            return true;
        }
    }
    public function actionNew(){
        $model=new Court('create');
        if($_POST['Court']){
            $model->attributes=$_POST['Court'];
            //先判断name是否重复
            if(!$this->checkName($_POST['Court']['name']))
            {
                $msg['msg']="添加失败！球场名称重复";
                $msg['status']=-1;
            }else
            {
                $model->record_time=date("Y-m-d H:i:s");
                $model->remark=htmlspecialchars($_POST['Court']['remark']);
                $model->facilities=htmlspecialchars($_POST['Court']['facilities']);
                $model->creatorid = Yii::app()->user->id;
                $coords = $this->getAddrPoint($_POST['Court']['addr']);
                //var_dump($coords);
                $model->lon = $coords['lon'];
                $model->lat = $coords['lat'];
                $model->court_id = Yii::app()->user->id.date("YmdHis");
                //var_dump($_POST['Court']);var_dump($model->attributes);exit;
                try{
                    $rs=$model->save();
                    if($rs){
                        $msg['msg']="添加成功！";
                        $msg['status']=1;
                        $model=new Court('create');
                    }else{
                        $msg['msg']="添加失败！";
                        $msg['status']=-1;
                    }
                }catch (Exception $e){
                    if($e->errorInfo[0]==23000){
                        $msg['msg']="球场编号重复！";
                        $msg['status']=-1;
                    }

                }

                //add log
                $log_args = array(
                    'module_id'=>$this->module_id,
                    'opt_name'=>'球场添加',
                    'opt_detail'=>"球场编号：".$model->court_id."球场名称：".$model->name.".".$msg['msg'],
                    'opt_status'=>$msg['status']==1 ? "00":"01",
                );
                Operatorlog::addLog($log_args);
            }
        }
        $this->render("new",array('model' => $model, 'msg' => $msg));
    }

    public function actionEdit(){
        $id=$_GET['id'];
        $model=Court::model()->findByPk($id);
        $city = $model->city;
        $province = substr($city,0,2)."0000";
        $model->province = $province;
        //var_dump($model->attributes);
        if($_POST['Court']){
            
            $model->setScenario("modify");
            $model->attributes=$_POST['Court'];
            $model->remark=htmlspecialchars($_POST['Court']['remark']);
            //var_dump($model->attributes);
            $rs=$model->save();
            if($rs){
                $msg['msg']="修改成功！";
                $msg['status']=1;
                //$model=new Staff('modify');
            }else{
                $msg['msg']="修改失败！";
                $msg['status']=0;
            }
            
            //add log
            $log_args = array(
                'module_id'=>$this->module_id,
                'opt_name'=>'球场信息编辑',
                'opt_detail'=>"球场编号：".$model->court_id.",球场名称:".$model->name.".".$msg['msg'],
                'opt_status'=>$msg['status']== 1 ? "00":"01",
            );
            Operatorlog::addLog($log_args);

        }
       //var_dump($msg);
        $this->layout = '//layouts/base';
        $this->render("edit",array('model' => $model, 'msg' => $msg));
    }

 
    public function actionCheckid(){
        $id=$_GET['id'];
        $data['status']=true;
        if($id){
            $cnt=Court::model()->count("name='".trim($id)."'");
            //print_r($operator);
            if($cnt > 0){
                $data['msg']=2;
            }else{
                $data['msg']=0;
            }
        }else{
            $data['status']=false;
        }
        print_r(json_encode($data));
    }

    public function actionGetCity()
    {
        $pid = trim($_GET['pid']);
        $selected = trim($_GET['selected']);
        
        $list = CityCode::getCity($pid);
        
        if(@count($list)>0)
        {
            foreach($list as $key=>$value)
            {
                echo '<option value="',$key,'"';
                if($selected == $key)
                {
                    echo ' selected';
                }
                echo '>',$value,'</option>';
            }
        }else
        {
            echo '<option value="">--选择--</option>';
        }
        exit;
    }
  
    /**
     * 球场删除
     * 包括 
     * 球场信息
     * 球场的图片
     * 球场的评论
     * 球场的附近设施
     * 暂时没实现
     */
    public function actionDel(){
        $id=$_POST['id'];
        $rs = true;
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
            ->from("g_court st")
            ->where("st.court_id='{$id}'")
            ->queryRow();
        $msg['status'] = true;
        if ($model) {
            $detail=array(
               '所在城市'=>$model['city'],
                '建立年代'=>$model['create_year'],
                '面积'=>$model['area'],
                '果岭草种'=>$model['green_grass'],
                '球场数据'=>$model['court_data'],
                '设计师'=>$model['designer'],
                '球道长度'=>$model['fairway_length'],
                '球道草种'=>$model['fairway_grass'],
                '球场设施'=>$model['facilities'],
                '球场简介'=>$model['remark'],
                '创建者'=> $model['creatorid'],
                '球场评价'=>'97分，8人点评，【设计:99,草坪:99,设施:97,服务:97】',
               
            );
            $msg['detail']=Utils::MakeDetailTable($detail);
        } else {
            $msg['status'] = false;
            $msg['detail'] = "获取球场信息失败！";
        }
        print_r(json_encode($msg));
    }
    
    
    private  function getAddrPoint($address)
    {
        if (!is_string($address))die("All Addresses must be passed as a string"); 
        //0MrPZA7fWlZeGSU1DPTCvolb
        $_url = sprintf('http://api.map.baidu.com/geocoder/v2/?address=%s&output=json&ak=0MrPZA7fWlZeGSU1DPTCvolb&callback=showLocation',rawurlencode($address)); 
        //var_dump($_url);
        $_result = false; 
        if($_result = file_get_contents($_url)) { 
            $_result = str_replace(array('showLocation&&showLocation(',')'), "", $_result);
            $result = (array)  json_decode($_result);
            //var_dump($result);
            if($result['status'] != 0) return false;
            $_match = $result['result']->location;
            $_coords['lat'] = $_match->lat; 
            $_coords['lon'] = $_match->lng; 
        } 
        return $_coords; 
    }
    
    public function actionShowPoint()
    {
        $addr = "广东省增城市永和镇余家庄水库";
        $coords = $this->getAddrPoint($addr);
        
        print_r($coords);
    }
    
    
    public function actionShowPic()
    {
        $id = trim($_GET['id']);
        $name=trim($_GET['name']);
        
        $_SESSION['cur_court_id'] = $id;
        $_SESSION['cur_court_name'] = $name;
        
        $this->render('pic_list');
    }
    
    /**
     * 表头
     * @return SimpleGrid
     */
    private function genPicDataGrid()
    {
        $t = new SimpleGrid($this->picGridId);
        $t->url = 'index.php?r=court/piclist';
        $t->updateDom = 'datagrid';
        $t->set_header('图片类型', '100', '');
        $t->set_header('图片', '100', '');   
        $t->set_header('操作', '100', '');
        return $t;
    }

    
    public function actionPicList()
    {
        $page = $_GET['page'] == '' ? 0 : $_GET['page']; //当前页码
        $_GET['page']=$_GET['page']+1;
        $args = $_GET['q']; //查询条件


        if ($_REQUEST['q_value'])
        {
            $args[$_REQUEST['q_by']] = $_REQUEST['q_value'];
        }

        $t = $this->genPicDataGrid();
        
        $args['from'] = 'court';

        $list = Img::queryList($page, $this->pageSize, $args);

        $this->renderPartial('_piclist', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }
    
    
    public function actionNewPic()
    {
        $model=new Img('create');
        
        if($_POST['Img']){
            $model->attributes=$_POST['Img'];
            $succ_num = 0;
            $false_num = 0;
            $up_msg = "";
            $files = $_FILES['upfile'];
            if(isset($files))
            {
                //var_dump($files['error']);
                foreach($files['error'] as $k=>$v)
                {
                    if($v == 0)
                    {
                        sleep(1);
                        //可以上传
                        $rs = $this->uploadImg($files['tmp_name'][$k],$files['name'][$k]);
                        //var_dump($rs);
                        if($rs['status'] == 0)
                        {
                            $up_msg .="第".($k+1)."张图片上传成功.";
                            $succ_num++;
                            //save to db
                            $model_img = new Img();
                            //$model_img->id = $this->getImgId();
                            $model_img->type = $_POST['Img']['type'];
                            $model_img->relation_id = $_POST['Img']['relation_id'];
                            $model_img->img_url = $rs['url'];
                            $model_img->record_time = date('Y-m-d H:i:s');
                            //var_dump($model->attributes);
                            $img_id = $model_img->save();
                            //var_dump($img_id);
                            if(!$img_id)
                            {
                                $up_msg .=  "第".($k+1)."张图片保存失败.";
                                $this->delImg($rs['url']);
                            }
                        }else{
                            $up_msg .= "第".($k+1)."张图片上传失败.";
                            $false_num++;
                        }
                    }  else 
                    {
                        $up_msg .= "第".($k+1)."张图片上传失败.";
                        $false_num++;
                    }
                }
                $msg['status'] = 1;
                $msg['msg'] = $succ_num>0?"上传成功。":"上传失败。";
                $msg['msg'] .= $succ_num>0?"成功数量:".$succ_num.",":"";
                $msg['msg'] .= $false_num>0?"失败数量:".$false_num.",":"";
                $msg['msg'] .= $up_msg;
                
            }else
            {
                $msg['msg']="添加失败！请至少上传一张图片";
                $msg['status']=-1;
            }           
            
        }
        $model->relation_id = $_SESSION['cur_court_id'];
        
        
        
        $this->render("new_pic",array('model' => $model, 'msg' => $msg));
    }
    
    
    
    
    public function actionLoadPic()
    {
        $name = trim($_GET['name']);
        $upload_dir = Yii::app()->params['upload_dir'];
        
        $file_name = $upload_dir.$name;
        $img_array = getimagesize($file_name);
	$mime = $img_array['mime'];
        $file_mime = explode("/", $mime);
        $suffix = $file_mime[1];
        header('Content-Type:image/'.$suffix);
        echo file_get_contents($file_name);
        exit;
    }
    
    
    public function actionDelPic()
    {
        $id = trim($_POST['id']);
        $info = Img::model()->findByPk($id);
        //var_dump($info);
        $url = $info['img_url'];
        $rs = Img::model()->deleteByPk($id);
        //var_dump($rs);
        $data['status'] = 0;
        $data['msg'] = "";
        if($rs)
        {
            $this->delImg($url);
            
        }else{
            $data['msg'] = "删除失败。";
        }
        
        echo json_encode($data);
        exit;
    }
    
    /**
     * 删除文件
     * @param type $url
     * @return boolean
     */
    private function delImg($url)
    {
        $upload_dir = Yii::app()->params['upload_dir'];
        $url_array = explode(".", $url);
        $file_small = $url_array[0]."_small.".$url_array[1];
        @unlink($upload_dir.$url);
        @unlink($upload_dir.$file_small);
        return true;
    }
    
    /**
     * 上传图片到服务器
     * @param type $tmp_file
     * @param type $tmp_name
     * @return string
     */
    private function uploadImg($tmp_file,$tmp_name)
    {
        $upload_dir = Yii::app()->params['upload_dir'];
        //路径是以目录/日期/时间+rand(100,999).png
        $upload_dir .= date('Ymd');
        if(!is_dir($upload_dir))
        {
            @mkdir($upload_dir."/",0777); 
        }
        $suffix = $this->getSuffix($tmp_name);
        $file = date('His').  rand(100, 9999);
        $new_file_path = $upload_dir."/".$file;
        $new_file_name = $new_file_path.".".$suffix;
        $new_file_name_s = $new_file_path."_small.".$suffix;
        $rs['status'] = 0;
        $rs['url'] = date('Ymd')."/".$file.".".$suffix;
        if(move_uploaded_file($tmp_file, $new_file_name))
        {
            //然后要生成一张缩略图
            $this->saveThumbnails($new_file_name, $new_file_name_s);
        }else{
            $rs['status'] = -1;
            $rs['msg'] = "上传图片到服务器失败";
        }
        return $rs;
    }
    
    
    private function getSuffix($name)
    {
        $name_a = explode(".", $name);
        return $name_a[count($name_a)-1];
    }
    
    
    /**
     * 保存头像
     * 180x180 50x50 30x30三个尺寸
     */
    function saveThumbnails($file_name,$file_name_small){
      
        $middle_size = 56;     
        $src = $file_name;
        //$suffix = strtolower($suffix);
        
        $img_array = getimagesize($file_name);
	$mime = $img_array['mime'];
        $file_mime = explode("/", $mime);
        $suffix = $file_mime[1];
        if($suffix == 'png')
        {
            $img_r = @imagecreatefrompng($src);
            
            $img_r_m = $this->resizeImage($img_r,$middle_size,$middle_size,$src);
            imagepng($img_r_m,$file_name_small);
        }else if($suffix == 'gif')
        {
            $img_r  = @imagecreatefromgif($src);
            
            $img_r_m = $this->resizeImage($img_r,$middle_size,$middle_size,$src);
            imagegif($img_r_m,$file_name_small);
            
        }else//jpg
        {
            $img_r = imagecreatefromjpeg($src);       
            $img_r_m = $this->resizeImage($img_r,$middle_size,$middle_size,$src);
            imagejpeg($img_r_m,$file_name_small);
           
        }        
        imagedestroy($img_r);   
        imagedestroy($img_r_m);
       
        return true;
    }

    /**
     *等比例缩放
     * @param <type> $im--image object
     * @param <type> $maxwidth  目标图片的宽度 例如168
     * @param <type> $maxheight  目标图片的高度 例如168
     */
    private function resizeImage($im,$maxwidth=116,$maxheight=116,$src)
    {
        //源图片的宽、高
        $pic_width = imagesx($im);
        $pic_height = imagesy($im);
        //$pic_array = getimagesize($src);
        //$pic_width = $pic_array[0];
        //$pic_height = $pic_array[1];
        //if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
        if(true)
        {

            $newwidth = $maxwidth;//$pic_width * $ratio;
            $newheight = $maxheight;//$pic_height * $ratio;
           
            if(function_exists("imagecopyresampled"))
            {
                $newim = imagecreatetruecolor($newwidth,$newheight);
                imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
            }
            else
            {
                $newim = imagecreate($newwidth,$newheight);
               imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
            }

            return $newim;

        }
        else
        {
            return $im;
        }
    }

    
    
    public function actionComment()
    {
        
        unset($_SESSION['cur_court_id']);
        unset($_SESSION['cur_court_name']);
        $this->render('comment_list');
    }
    
    /**
     * 表头
     * @return SimpleGrid
     */
    private function genCDataGrid()
    {
        $t = new SimpleGrid($this->cGridId);
        $t->url = 'index.php?r=court/commentlist';
        $t->updateDom = 'datagrid';
        $t->set_header('球场名称', '200', '');
        $t->set_header('服务', '50', '');   
        $t->set_header('设计', '50', '');   
        $t->set_header('设施', '50', '');   
        $t->set_header('草坪', '50', '');        
        $t->set_header('评分人', '100', '');  
        $t->set_header('评分时间', '100', '');  
        $t->set_header('备注', '100', '');  
        return $t;
    }

    
    public function actionCommentList($cur_court_id=null)
    {
        $page = $_GET['page'] == '' ? 0 : $_GET['page']; //当前页码
        $_GET['page']=$_GET['page']+1;
        $args = $_GET['q']; //查询条件


        if ($_REQUEST['q_value'])
        {
            $args[$_REQUEST['q_by']] = $_REQUEST['q_value'];
        }
        if($cur_court_id!=null)
        {
            $args['court_id'] = $cur_court_id;
        }
        $t = $this->genCDataGrid();
        //var_dump($args);
        $list = Comment::queryList($page, $this->pageSize, $args);
        
        if($list['rows'])
        {
            $court_list = Court::getCourtArray();
            foreach($list['rows'] as $key=>$row)
            {
                $court_id = $row['court_id'];
                $list['rows'][$key]['court_name'] = $court_list[$court_id];
            }
        }

        $this->renderPartial('_commentlist', array('t' => $t, 'rows' => $list['rows'], 'cnt' => $list['total_num'], 'curpage' => $list['page_num']));
    }
    
    /**
     * 某一个球场的评论
     */
    public function actionMyComment()
    {
        $id = trim($_GET['id']);
        $name=trim($_GET['name']);
        
        $_SESSION['cur_court_id'] = $id;
        $_SESSION['cur_court_name'] = $name;
        
        $this->render('my_comment',array('cur_court_id'=>$id));
    }


}