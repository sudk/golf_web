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
        <td class="maxname">姓名：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'user_name', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>
        <td class="maxname">会员卡：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'card_no', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), ''); ?></td>
    </tr>
    
    <tr>
        <td class="maxname">电话：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'phone', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required&number'); ?></td>
        <td class="maxname">E-Mail：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'email', array('title' => '请填写邮箱地址', 'class' => 'input_text'), 'email'); ?></td>
    </tr>
    <tr>
        <td class="maxname">性别：</td>
        <td class="mivalue"><?php echo $form->activeRadioButtonList($model, 'sex',Operator::GetSex(), array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>
        <td class="maxname">状态：</td>
        <td class="mivalue">
            <?php echo $form->activeDropDownList($model, 'status', User::GetStatus(), array('title' => '本项必选', 'class' => 'input_text', 'readonly' => "true"), 'required'); ?>
        </td>
    </tr>
    
    <tr>
    </tr>
    <tr>
        
        <td class="maxname">备注：</td>
        <td class="mivalue" colspan="3"><?php echo $form->activeTextField($model, 'remark', array('title' => '本项必填','class' => 'input_text','style'=>'width:400px;'), ''); ?></td>
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
        checkPassword();
    }
    function checkPassword(){
        var e = $("#Operator_password");
        var pass = $("#Operator_password").val();
        var pass_c = $("#Operator_passwordc").val();
        if(pass!=pass_c){
            flag = false;
            e.addClass('input_error iptxt');
            e.showTip({flagInfo:"两次输入密码不一致！"});
            e.focus();
        }
    }
    function checkId(obj) {
        var id = obj.value;
        //setLogin(id);
       // var id = $("#Operator_staffid").val();
        var e = $(obj);
        var ti = "登录账号已经存在！";
        $.ajax({
            url:'./?r=operator/operator/checkloginid',
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