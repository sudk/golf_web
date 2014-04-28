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
    echo '<input type=hidden name="id" value="'.$news_id.'"/>';
}
?>
<table class="formList">
    <tr>
        <td class="maxname">新闻标题：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'title', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 100,'onblur'=>$checkId), 'required');         
            ?>
        </td>
        <td class="maxname">&nbsp;</td>
        <td class="mivalue">
           <?php
                //echo $form->activeTextField($model, 'title', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 100,'onblur'=>$checkId), 'required');         
            ?>
        </td>
    </tr>
    
    <tr>
        
        <td class="maxname">新闻内容：</td>
        <td class="mivalue" colspan="3">
            <?php echo $form->activeTextArea($model, 'content', array('title' => '本项必填','id'=>'content','style'=>'height:100px;width:400px;float:left;'), 'required'); ?></td>
    </tr>
   
    <tr>
        <td class="maxname">新闻图片：</td>
        <td class="mivalue"  colspan="3">
            <span><a href="javascript:void(0);" onclick="javascript:addP(this);">[新增图片链接]</a></span>
            <span>注意：如果图片过多，请分批上传.<?php if($__model__=='edit'){ echo '<span style="color:red;">新增图片将会替换原有的图片，请确认需要替换原有图片</span>';}?></span>
        </td>
       
    </tr>
    <tr>
        <td class="maxname">&nbsp;</td>
        <td class="mivalue" id="pic_txt" colspan="3">
<!--            <p><input type="file" name="upfile[]" value="" class="input_text"/><span><a href="javascript:void(0);" onclick="javascript:delP(this);">[删除]</a></span></p>-->
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
        
        var desc_obj = jQuery("#content");
       
        var ti = "新闻的内容不超过512个字符";
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
        var ti = "新闻标题已经存在！";
        $.ajax({
            url:'./?r=service/news/checkid',
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