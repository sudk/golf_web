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
    echo $form->activeHiddenField($model,'court_id');
}
?>
<table class="formList">
    <tr>
        
        <td class="maxname">图片类型：</td>
        <td class="mivalue" colspan="3">
            <?php 
            $pic_type = array(
            '8'=>'球场标志',
            '0'=>'球场风景',
            '1'=>'球道',
        );
            echo $form->activeDropDownList($model, 'type',$pic_type, array('title' => '本项必填'), 'required'); 
            echo $form->activeHiddenField($model,'relation_id',array(),'required');
            ?></td>  
    </tr>
    <tr>
        <td class="maxname">上传图片：</td>
        <td class="mivalue"  colspan="3">
            <span><a href="javascript:void(0);" onclick="javascript:addP(this);">[新增图片链接]</a></span>
            <span>注意：如果图片过多，请分批上传</span>
        </td>
       
    </tr>
    <tr>
        <td class="maxname">&nbsp;</td>
        <td class="mivalue" id="pic_txt" colspan="3">
            <p><input type="file" name="upfile[]" value="" class="input_text"/><span><a href="javascript:void(0);" onclick="javascript:delP(this);">[删除]</a></span></p>
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
    function addP(obj){
        var v = '<p><input type="file" name="upfile[]" value="" class="input_text"/><span><a href="javascript:void(0);" onclick="javascript:delP(this);">[删除]</a></span></p>';
        jQuery("#pic_txt").append(v);
    }
    
    
    function delP(obj){
        jQuery(obj).parent().parent().remove();
    }
    
    
    
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
        
    }
    
    
    <?php if ($msg['status']) {
        echo "setTimeout(hideMsg,3000);
        ";
        echo "parent.itemQuery();";
    }
    ?>
</script>