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
}
?>
<table class="formList">
    <tr>
        <td class="maxname">商户权重：</td>
        <td class="mivalue">
           <?php
                echo $form->activeDropDownList($model, 'order', Adv::getOrder(),array('title' => '本项必填', 'class' => 'input_text'), 'required');         
            ?>
        </td>
        <td class="maxname">广告类型：</td>
        <td class="mivalue"><?php echo $form->activeDropDownList($model, 'type', Adv::getType(),array('title' => '本项必填', 'class' => 'input_text'), 'required'); ?></td>  
    </tr>
    
    <tr>
        <td class="maxname">有效期起始时间：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'start_time', array('title' => '本项必填', 'class' => 'Wdate input_text',"onfocus"=>"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen',errDealMode:0})"), 'required');         
            ?>
        </td>
        <td class="maxname">有效期截止时间：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'end_time', array('title' => '本项必填', 'class' => 'input_text Wdate', "onfocus"=>"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen',errDealMode:0})"), 'required'); ?></td>  
    </tr>
   
    
    <tr>
        
        <td class="maxname">广告图片：</td>
        <td class="mivalue" colspan="3">
            <input type="file" name="adv_img" value="" class="input_text" id="adv_img"/>
        </td>
    </tr>
    <?php
    if($__model__ == 'edit' && $model->link_url!=null)
    {
    ?>
    <tr>
        
        <td class="maxname">图片：</td>
        <td class="mivalue" colspan="3">
            <img src="index.php?r=court/loadpic&name=<?php echo $model->link_url;?>" style="width:50px;height:50px;"/>
        </td>
    </tr>
    <?php
    }
    ?>
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
<script type="text/javascript" src="js/JQdate/WdatePicker.js"></script>
<script type="text/javascript">
    
    
    
    var flag = true;
    function formSubmit() {
        <?php
        if($__model__ != 'edit')
        {
        ?>
            checkMyForm();
        <?php
        }
        ?>
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
        var desc_obj = jQuery("#adv_img");
        var ti = "请上传图片";
        var desc = desc_obj.val();
        if(desc.length == 0){
            desc_obj.addClass('input_error iptxt');
            desc_obj.showTip({flagInfo:ti});
            desc_obj.focus();
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