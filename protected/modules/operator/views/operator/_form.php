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
echo $form->activeHiddenField($model, 'cities', array(), '');
?>
<table class="formList">
    <tr>
        <td class="maxname">姓名：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'name', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>
        <td class="maxname">姓名全拼：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'abbreviation', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), ''); ?></td>
    </tr>
    <tr>
        <td class="maxname">性别：</td>
        <td class="mivalue"><?php echo $form->activeRadioButtonList($model, 'sex',Operator::GetSex(), array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 32), 'required'); ?></td>
        <td class="maxname">职称：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'jobtitle', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20), 'required'); ?></td>
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
        <td class="mivalue"><?php echo $form->activeTextField($model, 'id', array('title' => '本项必填', 'class' => 'input_text','onblur'=>$checkId,'readonly'=>$readonly,'maxlength' => 20), 'required'); ?></td>
    </tr>
    <tr>
        <td class="maxname">登录密码：</td>
        <td class="mivalue"><?php echo $form->activePasswordField($model, 'password', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 16), $pass_r); ?></td>
        <td class="maxname">确认登录密码：</td>
        <td class="mivalue"><?php echo $form->activePasswordField($model, 'passwordc', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 16), $pass_r); ?></td>
    </tr>
    <tr>
         <td class="maxname">操作员类型：</td>
        <td class="mivalue">
            <?php 
            if($__model__ == 'edit'){
                echo Operator::GetType($model->type);
                echo $form->activeHiddenField($model,'type',array());
            }else{
                echo $form->activeDropDownList($model, 'type', Operator::GetType(), array('title' => '本项必选', 'class' => 'input_text','id'=>'operator_type'), 'required'); 
            }
            ?>
        </td>
        <td class="maxname" id="oper_agent_id1" style="display: none;">所属代理商：</td>
        <td class="mivalue" id="oper_agent_id" style="display: none;">
            <?php 
            echo $form->activeDropDownList($model, 'agent_id',Agent::getAgentList(), array('title' => '本项必填','class' => 'input_text'), ''); 
            ?></td>
    </tr>
    <tr>
        <td class="maxname">状态：</td>
        <td class="mivalue">
            <?php echo $form->activeDropDownList($model, 'status', Operator::GetStatus(), array('title' => '本项必选', 'class' => 'input_text', 'readonly' => "true"), 'required'); ?>
        </td>
        <td class="maxname">备注：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'remark', array('title' => '本项必填','class' => 'input_text'), ''); ?></td>
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
    jQuery(document).ready(function(){
        <?php
        if($__model__=='edit' && $model->type == '2'){
            ?>
                jQuery("#oper_agent_id").show();
                jQuery("#oper_agent_id1").show();
                <?php
        }
        ?>
        jQuery("#operator_type").click(function(){
            var v = jQuery(this).val();
            if(v == '2'){
                jQuery("#oper_agent_id").show();
                jQuery("#oper_agent_id1").show();
            }
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