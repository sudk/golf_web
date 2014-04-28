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
    'focus' => array($model,'id'),
));
if($__model__!="edit"){
    $checkId="checkId(this);";
}else{
    $readonly=false;
}
?>
<table class="formList">
    <tr>
        <td class="maxname">卡号：</td>
        <td class="mivalue">
            <?php 
            if($__model__ == 'edit')
            {
                echo $model->id;
                echo $form->activeHiddenField($model,'id');
            }else{
                echo $form->activeTextField($model, 'id', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20,'onblur'=>$checkId), 'required&number'); 
            }
            ?>
        </td>
    </tr>
    <tr>
        <td class="maxname">卡名称：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'card_name', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>
    
    </tr>
    <tr>
        
        <td class="maxname">备注：</td>
        <td class="mivalue" colspan="3"><?php echo $form->activeTextArea($model, 'desc', array('title' => '本项必填','id'=>'desc'), ''); ?></td>
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
        var desc_obj = jQuery("#desc");
        var ti = "备注的内容不超过512个字符";
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
    
    function checkId(obj) {
        var id = obj.value;
        //setLogin(id);
       // var id = $("#Operator_staffid").val();
        var e = $(obj);
        var ti = "会员卡号已经存在！";
        $.ajax({
            url:'./?r=user/card/checkid',
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