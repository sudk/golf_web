<?php
if ($msg['status']) {
    $class = Utils::getMessageType($msg['status']);
    echo "<div class='{$class}' id='msg' style='width:600px;'>{$msg['msg']}</div>";
}
$form = $this->beginWidget('SimpleForm', array(
    'id' => 'form1',
    'enableAjaxSubmit' => false,
    'ajaxUpdateId' => 'form-container',
    'focus' => array($model,'id'),
));
$pass_r="required";
?>
<table class="formList">
    <tr>
        <td class="maxname">编号：</td>
        <td class="mivalue"><?php
            if($__model__=="edit"){
                $pass_r="";
                echo $model->id;
                echo $form->activeHiddenField($model, 'id',array(),'');
            }else{
                echo $form->activeTextField($model, 'id', array('title' => '本项必填', 'onblur' => 'checkId(this);', 'class' => 'input_text', 'maxlength' => 20), 'required');
            }
            ?></td>
        <td class="maxname">姓名：</td>
        <td class="mivalue"><?php echo $model->name;?></td>
    </tr>
    <tr>
        <td class="maxname">姓名全拼：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'abbreviation', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), ''); ?></td>
        <td class="maxname">职称：</td>
        <td class="mivalue"><?php echo $model->jobtitle;?></td>
 </tr>
    <tr>
        <td class="maxname">电话：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'tel', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required&number'); ?></td>
        <td class="maxname">E-Mail：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'email', array('title' => '请填写邮箱地址', 'class' => 'input_text'), 'email'); ?></td>
    </tr>
    <tr>
        <td class="maxname">QQ：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'qq', array('title' => 'QQ号码', 'class' => 'input_text', 'maxlength' => 32), 'number'); ?></td>
        <td class="maxname">账号：</td>
        <td class="mivalue"><?php echo $model->id; ?></td>
    </tr>
    <tr>
        <td class="maxname">登陆密码：</td>
        <td class="mivalue"><?php echo $form->activePasswordField($model, 'password', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 16), $pass_r); ?></td>
        <td class="maxname">确认登陆密码：</td>
        <td class="mivalue"><?php echo $form->activePasswordField($model, 'passwordc', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 16), $pass_r); ?></td>
    </tr>
    <tr>
        <td class="maxname">状态：</td>
        <td class="mivalue">
            <?php echo Operator::GetStatus($model->status); ?>
        </td>
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
    <tr>
        <td class="maxname"></td>
        <td class="mivalue">
            注：密码不修改请请空！
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<link rel="stylesheet" type="text/css" href="js/JQwindow/windowCSS.css"/>
<script type="text/javascript" src="js/JQwindow/windowJS.js"></script>
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
        setLogin(id);
        //var id = $("#Staff_id").val();
        var e = $(obj);
        var ti = "编号已经存在！";
        $.ajax({
            url:'./?r=operator/operator/checkid',
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
    function setLogin(id){
        $("#Operator_loginid").val(id);
    }
    <?php if ($msg['status']) {
        echo "setTimeout(hideMsg,3000);";
    }?>
</script>