<div id="content">
    <div class="title-box">
        <h1><span style="float:left;">添加球场图片</span><a href="./?r=court/showpic&id=<?php echo $_SESSION['cur_court_id'];?>&name=<?php echo $_SESSION['cur_court_name']?>" style="float:right;"><span class="ing_ico"></span><span>返回球场图片列表</span></a></h1>
    </div>
    <div class="tab-main" id="form-container">
            <?php $this->renderPartial('_picform', array('model' => $model, 'msg' => $msg));?>
    </div>
</div>