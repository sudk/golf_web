<div id="content">
    <div class="title-box">
        <h1><span style="float:left;">添加操作员</span><a href="./?r=operator/operator/list" style="float:right;"><span class="ing_ico"></span><span>返回列表</span></a></h1>
    </div>
    <div class="tab-main" id="form-container">
            <?php $this->renderPartial('_form', array('model' => $model, 'msg' => $msg,'suCityList'=>$suCityList));?>
    </div>
</div>