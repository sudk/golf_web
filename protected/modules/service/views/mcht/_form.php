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
     'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    'focus' => array($model,'name'),
));
if($__model__!="edit"){
    $checkId="checkId(this);";
}else{
    $readonly=false;
    echo $form->activeHiddenField($model,'id',array());
    echo '<input type=hidden name="id" value="'.$mcht_id.'"/>';
}
?>
<table class="formList">
    <tr>
        <td class="maxname">商户名称：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'facilitie_name', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20,'onblur'=>$checkId), 'required');         
            ?>
        </td>
        <td class="maxname">商户类型：</td>
        <td class="mivalue"><?php echo $form->activeDropDownList($model, 'type', CourtFacilities::getType(),array('title' => '本项必填', 'class' => 'input_text'), 'required'); ?></td>  
    </tr>
    
    <tr>
        <td class="maxname">附近球场：</td>
        <td class="mivalue">
           <?php
                echo $form->activeDropDownList($model, 'court_id',Court::getCourtArray(), array('title' => '本项必填', 'class' => 'input_text'), 'required');         
            ?>
        </td>
        <td class="maxname">电话：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'phone', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20), 'required'); ?></td>  
    </tr>
    <tr>
        <td class="maxname">地址：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'addr', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 64), 'required');         
            ?>
        </td>
        <td class="maxname">人均消费：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'consumption', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>  
    </tr>
    
    <tr>
        <td class="maxname">绿卡优惠：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'favourable', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 64), 'required');         
            ?>
        </td>
        <td class="maxname">距球场距离：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'distance', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>  
    </tr>
    
    <tr>
        
        <td class="maxname">特色：</td>
        <td class="mivalue" colspan="3"><?php echo $form->activeTextArea($model, 'feature', array('title' => '本项必填','id'=>'feature'), ''); ?></td>
    </tr>
    
    <tr>
        
        <td class="maxname">商户图片：</td>
        <td class="mivalue" colspan="3">
            <input type="file" name="mcht_img" value="" class="input_text"/>
        </td>
    </tr>
    <?php
    //var_dump($model->id);
    $row = Img::model()->find("relation_id='".$model->id."' and type='2'");
    //var_dump($row);
    if($__model__ == 'edit' && $row!=null)
    {
    ?>
    <tr>
        
        <td class="maxname">图片：</td>
        <td class="mivalue" colspan="3">
            <img src="index.php?r=court/loadpic&name=<?php echo $row['img_url'];?>" style="width:50px;height:50px;"/>
        </td>
    </tr>
    <?php
    }
    ?>
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
        var desc_obj = jQuery("#feature");
        var ti = "特色的内容不超过512个字符";
        var desc = desc_obj.val();
        if(desc.length > 512){
            desc_obj.addClass('input_error iptxt');
            desc_obj.showTip({flagInfo:ti});
            desc_obj.focus();
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
        var ti = "商户名称已经存在！";
        $.ajax({
            url:'./?r=service/mcht/checkid',
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