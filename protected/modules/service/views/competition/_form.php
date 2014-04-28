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
    echo '<input type=hidden name="id" value="'.$competition_id.'"/>';
}
?>
<table class="formList">
    <tr>
        <td class="maxname">赛事名称：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'name', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20,'onblur'=>$checkId), 'required');         
            ?>
        </td>
        <td class="maxname">所在球场：</td>
        <td class="mivalue"><?php echo $form->activeDropDownList($model, 'court_id', Court::getCourtArray(),array('title' => '本项必填', 'class' => 'input_text'), 'required'); ?></td>  
    </tr>
    
    
    <tr>
        <td class="maxname">起始时间：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'start_date', array('title' => '本项必填','value'=>($model->start_date?$model->start_date:date('Y-m-d')), 'class' => 'Wdate input_text',"onfocus"=>"WdatePicker({dateFmt:'yyyy-MM-dd',skin:'whyGreen',errDealMode:0})"), 'required');         
            ?>
        </td>
        <td class="maxname">截止时间：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'end_date', array('title' => '本项必填', 'value'=>($model->end_date?$model->end_date:date('Y-m-d')), 'class' => 'input_text Wdate', "onfocus"=>"WdatePicker({dateFmt:'yyyy-MM-dd',skin:'whyGreen',errDealMode:0})"), 'required'); ?></td>  
    </tr>
    <tr>
        <td class="maxname">支付方式：</td>
        <td class="mivalue">
           <?php
                echo $form->activeDropDownList($model, 'fee_type',  Competition::getType(), array('title' => '本项必填', 'class' => 'input_text'), 'required');         
            ?>
        </td>
        <td class="maxname">费用(分)：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'fee', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20), 'required&number'); ?></td>  
    </tr>
    
    <tr>
        
        <td class="maxname">费用包括：</td>
        <td class="mivalue" colspan="3"><?php echo $form->activeTextArea($model, 'fee_include', array('title' => '本项必填','id'=>'fee_include','style'=>'height:50px;'), 'required'); ?></td>
    </tr>
    <tr>
        
        <td class="maxname">费用不包括：</td>
        <td class="mivalue" colspan="3"><?php echo $form->activeTextArea($model, 'fee_not_include', array('title' => '本项必填','id'=>'fee_not_include','style'=>'height:50px;'), 'required'); ?></td>
    </tr>
    <tr>
        
        <td class="maxname">赛事内容：</td>
        <td class="mivalue" colspan="3"><?php echo $form->activeTextArea($model, 'plan', array('title' => '本项必填','id'=>'plan','style'=>'height:50px;'), 'required'); ?></td>
    </tr>
    <tr>
        
        <td class="maxname">赛事说明：</td>
        <td class="mivalue" colspan="3"><?php echo $form->activeTextArea($model, 'desc', array('title' => '本项必填','id'=>'desc','style'=>'height:50px;'), ''); ?></td>
    </tr>
    
    <tr>
        <td class="maxname">宣传图片：</td>
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
<script type="text/javascript" src="js/JQdate/WdatePicker.js"></script>
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
        var fi_obj = jQuery("#fee_include");
        var fni_obj = jQuery("#fee_not_include");
        var plan_obj = jQuery("#plan");
        var desc_obj = jQuery("#desc");
        var tf = "费用包括的内容不超过512个字符";
        var tfn = "费用不包括的内容不超过512个字符";
        var tp = "赛事的内容不超过512个字符";
        var ti = "赛事说明的内容不超过512个字符";
        var desc = desc_obj.val();
        var fiv = fi_obj.val();
        var finv = fni_obj.val();
        var plan = plan_obj.val();
        if(desc.length > 512){
            desc_obj.addClass('input_error iptxt');
            desc_obj.showTip({flagInfo:ti});
            desc_obj.focus();
            flag = false;
        }else{
            flag = true;
        }
        
        if(fiv.length > 512){
            desc_obj.addClass('input_error iptxt');
            desc_obj.showTip({flagInfo:tf});
            desc_obj.focus();
            flag = false;
        }else{
            flag = true;
        }
        
        if(finv.length > 512){
            desc_obj.addClass('input_error iptxt');
            desc_obj.showTip({flagInfo:tfn});
            desc_obj.focus();
            flag = false;
        }else{
            flag = true;
        }
        
        if(plan.length > 512){
            desc_obj.addClass('input_error iptxt');
            desc_obj.showTip({flagInfo:tp});
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
        var ti = "赛事名称已经存在！";
        $.ajax({
            url:'./?r=service/competition/checkid',
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