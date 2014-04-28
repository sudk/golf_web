<?php
if ($msg['status']) {
    $class = Utils::getMessageType($msg['status']);
    echo "<center<div class='{$class}' id='msg' style='width:700px;'>{$msg['msg']}</div>";
}
$form = $this->beginWidget('SimpleForm', array(
    'id' => 'form1',
    'enableAjaxSubmit' => false,
    'ajaxUpdateId' => 'form-container',
));
?>
<table class="formList">
    <tr>
        <td class="name">标题：</td>
        <td class="mivalue" colspan="3"><?php echo $form->activeTextField($model, 'title', array('title' => '本项必填', 'class' => 'input_text address', 'maxlength' => 32), 'required'); ?></td>
    </tr>
    <tr>
        <td class="name">内容：</td>
        <td class="mivalue"><?php echo $form->activeTextArea($model, 'content', array('title' => '本项必填', 'style' => 'width:800px;height:300px;', 'maxlength' => 32), ''); ?></td>
    </tr>
    <tr>
        <td class="name">类型：</td>
        <td class="mivalue">
            <?php echo $form->activeDropDownList($model, 'type', MsgBox::GetType(), array('title' => '本项必选', 'class' => 'input_text', 'readonly' => "true"), ''); ?>
        </td>
    </tr>
    <tr>
        <td class="name">接收人：</td>
        <td>
            <?php if (!empty($op_ar)) :?>
            <table style="width: 90%;" cellpadding="0" cellspacing="0">
                <?php $i=0;
                echo "<tr><td colspan='2'><label><input type='checkbox' name='checkall[]' value='1' onclick='checkall(this)' />所有</label></td></tr>";
                foreach ($op_ar as $stid => $name) {
                    if($stid===''){continue;}
                    if($i==0){
                        echo "
                                       <tr><td width='20px;'></td><td><label><input type='checkbox' name='listener[]' value='{$stid}' />{$name}</label>";
                    }else{
                        echo "<label><input type='checkbox' name='listener[]' value='{$stid}' />{$name}</label>";
                    }
                    $i++;
                    if($i>6){
                        echo "</td></tr>";
                        $i=0;
                    }
                }
                if($i<=6){
                    echo "</td></tr>";
                    $i=0;
                }
                    ?>
            </table>
            <?php endif;?>
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
</table>
<?php $this->endWidget(); ?>
<script charset="utf-8" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('#MsgBox_content', {
            resizeType : 1,
            allowPreviewEmoticons : false,
            allowImageUpload : false,
            items : [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'link']
        });
    });

    var flag = true;
    function formSubmit() {
        var ht=editor.html();
        $("#MsgBox_content").val(ht);
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
    <?php if ($msg['status']) {
        echo "setTimeout(hideMsg,3000);";
    }?>
    var checkall=function(obj){
        var v=$(obj).val()*1;
        var begin=false;
        $("input[type='checkbox']").each(function(){
            if($(this).val()!=v&&$(this).attr('name')=="checkall[]"){
                begin=false;
                //return false;
            }else if($(this).val()==v){
                begin=true;
            }else if(begin){
                $(this).attr("checked",obj.checked);
            }
        })
    }
</script>