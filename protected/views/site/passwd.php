<?php
if ($msg['status']) {
    $class = Utils::getMessageType($msg['status']);
    echo "<div class='{$class}' id='msg'>{$msg['msg']}</div>";
}
$form = $this->beginWidget('SimpleForm', array(
    'id' => 'form1',
    'enableAjaxSubmit' => false,
    'ajaxUpdateId' => 'form-container',
    'focus' => array($model, name),
    'htmlOptions' => array(),
));
?>
<table class="formList" style="margin-top: 30px;">
    <tr>
        <td class="name">当前密码：</td>
        <td class="value">
            <?php echo $form->passwordField('current_passwd', '', array('id' => 'current_passwd', 'class' => 'input_text', 'value' => '', 'maxlength' => '16'), 'required'); ?>
            <span id="tipBox-passwd" class="colGray"></span>
        </td>
    </tr>

    <tr>
        <td class="name">新密码：</td>
        <td class="value">
            <?php echo $form->passwordField('new_passwd', '', array('id' => 'new_passwd', 'class' => 'input_text', 'value' => '', 'maxlength' => '16'), 'required'); ?>
            <span id="tipBox-new_passwd" class="colGray"></span>
        </td>
    </tr>


    <tr>
        <td class="name">确认密码：</td>
        <td class="value">
            <?php echo $form->passwordField('confirm_passwd', '', array('id' => 'confirm_passwd', 'class' => 'input_text', 'value' => '', 'maxlength' => '16'), 'required'); ?>
            <span id="tipBox-confirm_passwd" class="colGray"></span>
        </td>
    </tr>
    <tr class="btnBox">
        <td colspan="2">
                            <span class="sBtn" >
                                <a class="left" id="btnSubmit"> 修改 </a><a class="right"></a>
                            </span>
                            <span class="sBtn-cancel" >
                                <a class="left" href="javascript:void(0);"  id="btnClose">关闭</a><a class="right"></a>
                            </span>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#btnSubmit").click(function () {
            if (jQuery("#new_passwd").attr('value') != jQuery("#confirm_passwd").attr('value')) {
                alert("确认密码与新密码不相等，请重新输入。");
                return false;
            }
            jQuery("#form1").submit();
        });
        jQuery("#btnClose").click(function () {
            closeWin();
        });
    });
    function closeWin(){
        parent.$("#windown-close").click();
    }
    function hideMsg() {
        $("#msg").hide("slow");
    }
    <?php if ($msg['status']) {
        echo "setTimeout(closeWin,3000);";
    }?>
</script>