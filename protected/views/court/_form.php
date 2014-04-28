<style type="text/css">
    .city_list {
        text-align:left;
        list-style-type:none;
        width:260px;
    }
    .city_list li {
        display:inline-block;
        list-style-type:none;
        padding: 3px;
    }
</style>
<?php
if ($msg['status']) {
    $class = Utils::getMessageType($msg['status']);
    echo "<div class='{$class}' id='msg' style='width:700px;'>{$msg['msg']}</div>";
}
$form = $this->beginWidget('SimpleForm', array(
    'id' => 'form1',
    'enableAjaxSubmit' => false,
    'ajaxUpdateId' => 'form-container',
    'focus' => array($model,'name'),
));
if($__model__!="edit"){
    $checkId="checkId(this);";
}else{
    $readonly=false;
    echo $form->activeHiddenField($model,'court_id');
}
?>
<table class="formList">
    <tr>
        <td class="maxname">球场名称：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'name', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20,'onblur'=>$checkId), 'required');         
            ?>
        </td>
        <td class="maxname">球场模式：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'model', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>  
    </tr>
    <tr>
        <td class="maxname">所在城市：</td>
        <td class="mivalue">
           <?php
                $province_list = CityCode::getProvince();
                echo $form->activeDropDownList($model, 'province',$province_list, array('title' => '本项必填', 'class' => 'input_text','id'=>'province_code'), 'required');  
                echo $form->activeDropDownList($model, 'city',array(''=>'--选择--'), array('title' => '本项必填', 'class' => 'input_text','id'=>'city_code'), 'required'); 
            ?>
        </td>
        <td class="maxname">建立年代：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'create_year', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required&number'); ?></td>  
    </tr>
    <tr>
        <td class="maxname">球场面积：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'area', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20), 'required');         
            ?>
        </td>
        <td class="maxname">果岭草种：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'green_grass', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>  
    </tr>
    <tr>
        <td class="maxname">球场数据：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'court_data', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20), 'required');         
            ?>
        </td>
        <td class="maxname">设计师：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'designer', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>  
    </tr>
    <tr>
        <td class="maxname">球道长度：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'fairway_length', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20), 'required');         
            ?>
        </td>
        <td class="maxname">球道草种：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'fairway_grass', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>  
    </tr>
    <tr>
        <td class="maxname">球场电话：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'phone', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20), 'required&phone');         
            ?>
        </td>
        <td class="maxname">球场地址：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'addr', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 64), 'required'); ?></td>  
    </tr>
    <tr>
        
        <td class="maxname">球场设施：</td>
        <td class="mivalue" colspan="3"><?php echo $form->activeTextArea($model, 'facilities', array('title' => '本项必填','id'=>'facilities'), ''); ?></td>
    </tr>
    
    <tr>
        
        <td class="maxname">球场简介：</td>
        <td class="mivalue" colspan="3"><?php echo $form->activeTextArea($model, 'remark', array('title' => '本项必填','id'=>'remark'), ''); ?></td>
    </tr>
    <tr class="btnBox">
        <td colspan="4">
            <span class="sBtn">
                <a class="left" href="javascript:formSubmit();">保存</a><a class="right"></a>
            </span>
            <span class="sBtn-cancel">
                <a class="left" href="javascript:formReset();">重置</a><a class="right"></a>
            </span>
        </td>
    </tr>
</table>
<?php $this->endWidget();?>
<script type="text/javascript">
    <?php
    if($__model__=="edit" && $model->province){
        ?>
            //alert("a");
            var v = jQuery("#province_code").val();
            var city = '<?php echo $model->city;?>';
            var url = "index.php?r=court/getcity&pid="+v+"&selected="+city;
            //alert(url);
            jQuery.post(url,function(data){
                jQuery("#city_code").html(data);
            });
            <?php
    }
    ?>
    jQuery("#province_code").click(function(){
        var v = jQuery(this).val();
        var url = "index.php?r=court/getcity&pid="+v;
        //alert(url);
        jQuery.post(url,function(data){
            jQuery("#city_code").html(data);
        });
    });
    
    
    var flag = true;
    function formSubmit() {
        checkMyForm();
        if (flag)
            $("form:first").submit();
        else
            flag=true;
    }
    function formReset() {
        document.getElementById("form1").reset();
    }
    function hideMsg() {
        $("#msg").hide("slow");
    }
    function checkMyForm(){
        var desc_obj = jQuery("#remark");
        var ti = "球场简介的内容不超过512个字符";
        var desc = desc_obj.val();
        if(desc.length > 512){
            desc_obj.addClass('input_error iptxt');
            desc_obj.showTip({flagInfo:ti});
            desc_obj.focus();
            flag = false;
        }else{
            flag = true;
        }
        
         var f_obj = jQuery("#facilities");
         var f_ti = "球场设施的内容不超过512个字符";
         var f = f_obj.val();
        if(f.length > 512){
            f_obj.addClass('input_error iptxt');
            f_obj.showTip({flagInfo:f_ti});
            f_obj.focus();
            flag = false;
        }else{
            flag = true;
        }
    }
    //检测球场的名称不能重复
    function checkId(obj) {
        var id = obj.value;
        //setLogin(id);
       // var id = $("#Operator_staffid").val();
        var e = $(obj);
        var ti = "球场名称已经存在！";
        $.ajax({
            url:'./?r=court/checkid',
            data:{id:id},
            dataType:"json",
            success:function (data) {
                if (data.status) {
                    if (data.msg > 0) {
                        e.addClass('input_error iptxt');
                        e.showTip({flagInfo:ti});
                        e.focus();
                        flag = false;
                    } else {
                        flag = true;
                    }
                }
            }
        })
    }
    
    <?php if ($msg['status']) {
        echo "setTimeout(hideMsg,3000);
        ";
        echo "parent.itemQuery();";
    }
    ?>
</script>