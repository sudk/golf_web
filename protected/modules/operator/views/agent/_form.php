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
    $pass_r="required";
    $checkId="checkId(this);";
}else{
    $readonly=false;
}
?>
<table class="formList">
    <tr>
        <td class="maxname">代理商名称：</td>
        <td class="mivalue"><?php 
        if($__model__ == 'edit'){
            echo $model->agent_name;
            echo $form->activeHiddenField($model,'agent_name',array());
        }else{
            echo $form->activeTextField($model, 'agent_name', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32,'onblur'=>$checkId), 'required'); 
        }
        ?></td>
        <td class="maxname">联系人：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'contactor', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>
    </tr>
    <tr>
        <td class="maxname">联系电话：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'phone',array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20), 'required'); ?></td>
        <td class="maxname">佣金：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'extra', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20), 'required&number'); ?></td>
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
        //checkPassword();
    }
    
    function checkId(obj) {
        var id = obj.value;
        
        var e = $(obj);
        var ti = "代理商名称已经存在！";
        $.ajax({
            url:'./?r=operator/agent/checkagentname',
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