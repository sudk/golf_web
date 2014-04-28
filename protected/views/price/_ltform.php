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

//echo $form->activeHiddenField($model,'court_id');

?>
<table class="formList">
    
    <tr>
        <td class="maxname">上传文件：</td>
        <td class="mivalue"  colspan="3">
            <p><input type="file" name="template_file" id="upfile" value="" class="input_text"/></p>
            <input type="text" name="tag" value="<?php echo $tag;?>" id="tag"/>
        </td>
       
    </tr>
    <tr>
        <td class="maxname">说明：</td>
        <td class="mivalue" colspan="3">
            <p>说明：</p><p>
1,请按模板格式填写价格.</p><p>
2,选择填写好的模板,点击导入.</p><p>
3,价格导入完成.如格式填写不正确,将导入不成功 .</p><p>
规则说明：</p><p>
（以下所说的“格式错误”：指日期重叠、果,僮,车,柜,简餐,保险,小费不是（0或者1）、球场名称为空,编码为空。）</p><p>
1. 默认价格：</p><p>
如果：模板中所有字段， 有格式错误，报错，提示用户重新修改后再导入。</p><p>
如果：模板中所有字段 ，没有全填写完整，报错，提示用户重新修改后再导入。</p><p>
如果：模板中所有字段，全为空，跳过。</p><p>
如果：开始日期,结束日期 为空，跳过。</p><p>
2. 特殊日设置</p><p>
如果：价格与对应日期，有格式错误，报错，提示用户重新修改后再导入。</p><p>
如果：对应日期的价格为空，跳过。</p>
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
        var tag = jQuery("#tag").val();
        var file_obj = jQuery("#upfile");
        var file_name = file_obj.val();
        var ti = "请上传文件";
        if(file_name == ""){
            file_obj.addClass('input_error iptxt');
            file_obj.showTip({flagInfo:ti});
            file_obj.focus();
            flag = false;
        }else{
            flag = true;
        }
    }
    
    
    <?php if ($msg['status']) {
        echo "setTimeout(hideMsg,3000);
        ";
        echo "parent.itemQuery();";
    }
    ?>
</script>