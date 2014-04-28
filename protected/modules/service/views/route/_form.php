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
        <td class="maxname">套餐名称：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'trip_name',array('title' => '本项必填', 'class' => 'input_text','onblur'=>$checkId), 'required');         
            ?>
        </td>
        <td class="maxname">所在球场：</td>
        <td class="mivalue"><?php echo $form->activeDropDownList($model, 'court_id', Court::getCourtArray(),array('title' => '本项必填', 'class' => 'input_text'), 'required'); ?></td>  
    </tr>
    
    <tr>
        <td class="maxname">所在城市：</td>
        <td class="mivalue">
           <?php
                $province_list = CityCode::getProvince();
                echo $form->activeDropDownList($model, 'province',$province_list, array('title' => '本项必填', 'class' => 'input_text','id'=>'province_code'), 'required');  
                echo $form->activeDropDownList($model, 'city',array(''=>'--选择--'), array('title' => '本项必填', 'class' => 'input_text','id'=>'city_code'), 'required'); 
            ?>
        </td>
        <td class="maxname">平日价格：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'normal_price',array('title' => '本项必填', 'class' => 'input_text'), 'required'); ?></td>  
    </tr>
    <tr>
        <td class="maxname">假日价格：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'holiday_price',array('title' => '本项必填', 'class' => 'input_text'), 'required');         
            ?>
        </td>
        <td class="maxname">包括平日和假日的价格：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'other_price', array('title' => '本项必填', 'class' => 'input_text'), 'required'); ?></td>  
    </tr>
    <tr>
        <td class="maxname">支付方式：</td>
        <td class="mivalue">
           <?php
                echo $form->activeDropDownList($model, 'pay_type',Trip::getPayType(),array('title' => '本项必填', 'class' => 'input_text'), 'required');         
            ?>
        </td>
        <td class="maxname">是否订单确认：</td>
        <td class="mivalue"><?php echo $form->activeDropDownList($model, 'is_check',Trip::getIsCheck(), array('title' => '本项必填', 'class' => 'input_text'), 'required'); ?></td>  
    </tr>
    <tr>
        <td class="maxname">起始日期：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'start_date', array('title' => '本项必填', 'class' => 'Wdate input_text',"onfocus"=>"WdatePicker({dateFmt:'yyyy-MM-dd',skin:'whyGreen',errDealMode:0})"), 'required');         
            ?>
        </td>
        <td class="maxname">截止时间：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'end_date', array('title' => '本项必填', 'class' => 'input_text Wdate', "onfocus"=>"WdatePicker({dateFmt:'yyyy-MM-dd',skin:'whyGreen',errDealMode:0})"), 'required'); ?></td>  
    </tr>
   <tr>
        
        <td class="maxname">备注：</td>
        <td class="mivalue" colspan="3">
            <?php
            echo $form->activeTextArea($model,'desc',array('title'=>'不多于512个字符','id'=>'desc'),'');
            ?>
        </td>
    </tr>
    
    <tr>
        
        <td class="maxname">套餐图片：</td>
        <td class="mivalue" colspan="3">
            <input type="file" name="trip_img" value="" class="input_text" id="trip_img"/>
        </td>
    </tr>
    <?php
    $row = Img::model()->find("relation_id='".$model->id."' and type='".Img::TYPE_TRIP."'");
    if($__model__ == 'edit' && $row!=null)
    {
    ?>
    <tr>
        
        <td class="maxname">图片：</td>
        <td class="mivalue" colspan="3">
            <img src="index.php?r=court/loadpic&name=<?php echo $row['img_url'];?>" style="width:50px;height:50px;"/>
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
    
    <?php
    if($__model__=="edit" && $model->province){
        ?>
            //alert("a");
            var v = jQuery("#province_code").val();
            var city = '<?php echo $model->city;?>';
            var url = "index.php?r=court/getcity&pid="+v+"&selected="+city;
            //alert(url);
            jQuery.post(url,function(data){
                jQuery("#city_code").html(data);
            });
            <?php
    }
    ?>
    jQuery("#province_code").click(function(){
        var v = jQuery(this).val();
        var url = "index.php?r=court/getcity&pid="+v;
        //alert(url);
        jQuery.post(url,function(data){
            jQuery("#city_code").html(data);
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
        var desc_obj = jQuery("#desc");
        var ti = "备注内容不超过512个字符";
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
    
    function checkId(obj) {
        var id = obj.value;
        //setLogin(id);
       // var id = $("#Operator_staffid").val();
        var e = $(obj);
        var ti = "套餐名称已经存在！";
        $.ajax({
            url:'./?r=service/route/checkid',
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