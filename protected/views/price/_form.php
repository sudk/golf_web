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
    'focus' => array($model,'name'),
));
$price_row = array();
$status_row = array();
if($__model__=="edit"){
    echo $form->activeHiddenField($model,'id');
    //分解Detail_rows
    
    if(@count($detail_rows) > 0)
    {
        
        foreach($detail_rows as $detail_row)
        {
            $day = $detail_row['day'];
            if($day == '0'){
                $day = '7';
            }
            if($detail_row['start_time'] == "" && $detail_row['end_time'] == ""){
                
                $price_row[$day."_default"] = $detail_row['price'];
                $status_row[$day."_default"] = $detail_row['status'];
            }else{
                $price_row[$day][] = array(
                    'start_time'=>$detail_row['start_time'],
                    'end_time'=>$detail_row['end_time'],
                    'price'=>$detail_row['price'],
                    'id'=>$detail_row['id']
                    );
            }
            
        }
    }
}
//var_dump($price_row);
//var_dump($status_row);
?>
<table class="formList">
    <tr>
        <td class="maxname">起始日期：</td>
        <td class="mivalue">
           <?php
                echo $form->activeTextField($model, 'start_date', array('title' => '本项必填','value'=>($model->start_date?$model->start_date:date('Y-m-01')), 'class' => 'Wdate input_text',"onfocus"=>"WdatePicker({dateFmt:'yyyy-MM-dd',skin:'whyGreen',errDealMode:0})"), '');         
            ?>
        </td>
        <td class="maxname">截止日期：</td>
        <td class="mivalue"><?php echo $form->activeTextField($model, 'end_date', array('title' => '本项必填','value'=>($model->end_date?$model->end_date:date('Y-m-t')), 'class' => 'Wdate input_text',"onfocus"=>"WdatePicker({dateFmt:'yyyy-MM-dd',skin:'whyGreen',errDealMode:0})"), ''); ?></td>  
    </tr>
    <tr>
        <td class="maxname">球场名称：</td>
        <td class="mivalue">
           <?php
                $court_list = Court::getCourtArray();
                echo $court_list[$model->court_id];
                echo $form->activeHiddenField($model,'court_id',array());
                //echo $form->activeDropDownList($model, 'court_id',Court::getCourtArray(), array('title' => '本项必填', 'class' => 'input_text'), 'required');         
            ?>
        </td>
        <td class="maxname">报价单类型：</td>
        <td class="mivalue">
           <?php
                //echo $form->activeRadioButtonList($model, 'type',  Policy::getType(), array('title' => '本项必填', 'class' => 'input_text','template'=>'<span class="check">{input}{label}</span>','separator'=>' '), 'required'); 
                $type = $model->type;
                echo Policy::getType($type);
                echo $form->activeHiddenField($model,'type',array());
            ?>
        </td>
    </tr>
    <tr>
        <td class="maxname">支付方式：</td>
        <td class="mivalue">
           <?php
                echo $form->activeRadioButtonList($model, 'pay_type',Trip::getPayType(), array('title' => '本项必填', 'class' => 'input_text','template'=>'<span class="check">{input}{label}</span>','separator'=>' '), 'required');         
            ?>
        </td>
        <td class="maxname">包含18洞果岭：</td>
        <td class="mivalue"><?php 
        $flag_list = Policy::getYesOrNot();
        echo $form->activeRadioButtonList($model, 'is_green',$flag_list, array('title' => '本项必填', 'class' => 'input_text','value'=>'0','template'=>'<span class="check">{input}{label}</span>','separator'=>' '), 'required'); ?></td>  
    </tr>
    <tr>
        <td class="maxname">包含球童：</td>
        <td class="mivalue">
           <?php
               echo $form->activeRadioButtonList($model, 'is_caddie',$flag_list, array('title' => '本项必填', 'class' => 'input_text','template'=>'<span class="check">{input}{label}</span>','separator'=>' '), 'required'); ?></td> 
        <td class="maxname">包含球车：</td>
        <td class="mivalue"><?php echo $form->activeRadioButtonList($model, 'is_car',$flag_list, array('title' => '本项必填', 'class' => 'input_text','template'=>'<span class="check">{input}{label}</span>','separator'=>' '), 'required'); ?></td> 
    </tr>
    <tr>
        <td class="maxname">包含衣柜：</td>
        <td class="mivalue">
           <?php
             echo $form->activeRadioButtonList($model, 'is_wardrobe',$flag_list, array('title' => '本项必填', 'class' => 'input_text','template'=>'<span class="check">{input}{label}</span>','separator'=>' '), 'required'); ?></td> 
        <td class="maxname">包含简餐：</td>
        <td class="mivalue"><?php echo $form->activeRadioButtonList($model, 'is_meal',$flag_list, array('title' => '本项必填', 'class' => 'input_text','template'=>'<span class="check">{input}{label}</span>','separator'=>' '), 'required'); ?></td> 
    </tr>
    <tr class="line">
        <td class="maxname">包含保险：</td>
        <td class="mivalue">
           <?php
               echo $form->activeRadioButtonList($model, 'is_insurance',$flag_list, array('title' => '本项必填', 'class' => 'input_text','template'=>'<span class="check">{input}{label}</span>','separator'=>' '), 'required'); ?></td> 
        <td class="maxname">包含小费：</td>
        <td class="mivalue"><?php echo $form->activeRadioButtonList($model, 'is_tip',$flag_list, array('title' => '本项必填', 'class' => 'input_text','template'=>'<span class="check">{input}{label}</span>','separator'=>' '), 'required'); ?></td> 
    </tr>
    <?php
    $week_day = array(
        '1'=>'周一',
        '2'=>'周二',
        '3'=>'周三',
        '4'=>'周四',
        '5'=>'周五',
        '6'=>'周六',
        '7'=>'周日',
    );
    if($type == Policy::TYPE_SPECIAL)
    {
        $week_day = array();
    }
    if(@count($week_day) > 0)
    {
        foreach($week_day as $key=>$value)
        {
    ?>
    <tr>
        <td class="maxname"><?php echo $value;?>默认价：</td>
        <td class="mivalue">
           <input type="text" name="<?php echo $key;?>_price" value="<?php echo $price_row[$key."_default"];?>" class="input_text"/>
        </td> 
        <td class="maxname">
            <input type="checkbox" name="<?php echo $key;?>_disable" value="1" onclick="javascript:check(this,'<?php echo $key;?>');" <?php echo $status_row[$key.'_default']=='1'?" checked":"";?>/><label>禁止预订</label>
            <input type="hidden" name="<?php echo $key;?>_status" id="<?php echo $key;?>_status" value="<?php echo $status_row[$key.'_default']?$status_row[$key.'_default']:0;?>"/>
        </td>
        <td class="mivalue">
            <?php
            if($type == Policy::TYPE_FOVERABLE)
            {
            ?>
            <a href="javascript:void(0);" onclick="addTimePeriod('<?php echo $key;?>');"><span class="add_ico"></span></a>
            <?php
            }
            ?>
        </td>
    </tr>
    <?php
    $num = 0;
    
    if(isset($price_row) && isset($price_row[$key]))
    {
        $num = @count($price_row[$key]);
    }
    //var_dump($num);
    ?>
    <tr style="<?if($num==0){?>display:none;<?php }?>" id="<?php echo $key;?>_tr">
        <td class="maxname"></td>
        <td class="mivalue" colspan="3"  id="<?php echo $key;?>_td">
            <?php
            if($num > 0)
            {
                foreach($price_row[$key] as $detail_price)
                {
                    ?>
                    <p>
                    <span>开始时间：</span>
                    <select name="<?php echo $key;?>_start_time[]" style="width:100px;">
                    <?php
                    $time_array = Yii::app()->params['time_array'];
                    foreach($time_array as $k=>$v){
                        ?>
                        <option value="<?php echo $k;?>" <?php if($detail_price['start_time'] == $k){ echo " selected";}?>><?php echo $v;?></option>
                        <?php
                    }
                    ?>
                    </select>
                    <span>结束时间：</span>
                    <select name="<?php echo $key;?>_end_time[]" style="width:100px;">
                    <?php
                    foreach($time_array as $k=>$v){
                        ?>
                        <option value="<?php echo $k;?>" <?php if($detail_price['end_time'] == $k){ echo " selected";}?>><?php echo $v;?></option>
                        <?php
                    }
                    ?>
                    </select>
                    <span>价格:</span>
                    <input type="text" name="<?php echo $key;?>_d_price[]" value="<?php echo $detail_price['price']?>" style="width:100px;"/>
                    <a href="javascript:void(0);" onclick="javascript:delItemFromDB(this,'<?php echo $detail_price['id'];?>');"><span class="del_ico"></span></a>
                    </p> 
                     <?php
                }
            }
            ?>
        </td>
    </tr>
    <?php
        }
    }
    if($type == Policy::TYPE_SPECIAL)
    {
        
        ?>
    <tr>
        <td class="maxname">默认价：</td>
        <td class="mivalue">
           <input type="text" name="default_price" value="<?php echo $price_row['-1_default'];?>" class="input_text"/>
        </td> 
        <td class="maxname">
            <input type="checkbox" name="default_disable" value="1" onclick="javascript:check(this,'default');" <?php echo $status_row['-1_default']=='1'?" checked":"";?>/><label>禁止预订</label>
            <input type="hidden" name="default_status" id="default_status" value="<?php $status_row['-1_default']?$status_row['-1_default']:0;?>"/>
        </td>
        <td class="mivalue">
<!--            
            <a href="javascript:void(0);" onclick="addTimePeriod('<?php echo $key;?>');"><span class="add_ico"></span></a>
            -->
        </td>
    </tr>
         <?php
    }
    ?>
    <tr>
        <td class="maxname">预订须知：</td>
        <td class="mivalue" colspan="3">
           <?php
                echo $form->activeTextArea($model, 'remark', array('title' => '本项必填',"style"=>'height:40px;','class'=>'grayTips'), 'required');         
            ?>
            <p>球车单差，球童单差，与价格相关的说明</p>
        </td>
    </tr>
    <tr>
        <td class="maxname">取消规则：</td>
        <td class="mivalue" colspan="3">
            <?php echo $form->activeTextArea($model, 'cancel_remark', array('title' => '本项必填','style'=>'height:40px;'), 'required'); ?>
            <p>取消，减人需要提前x天，当天取消是否罚款。</p>
        </td>  
    </tr>
    
    <?php
    if($__model__ == 'edit')
    {
        ?>
        <tr>
        <td class="maxname">状态：</td>
        <td class="mivalue" colspan="3">
           <?php
                echo $form->activeRadioButtonList($model, 'status',  Policy::GetStatus(), array('title' => '本项必填', 'class' => 'input_text'), 'required');         
            ?>
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
    
    function addTimePeriod(id){
        jQuery("#"+id+"_tr").show();
        var content = '<p>';
                content += '<span>开始时间：</span>';
                content += '<select name="'+id+'_start_time[]" style="width:100px;">';
                <?php
                $time_array = Yii::app()->params['time_array'];
                foreach($time_array as $k=>$v){
                    ?>
                    content += '<option value="<?php echo $k;?>"><?php echo $v;?></option>';
                    <?php
                }
                ?>
                content += '</select>';
                content += '<span>结束时间：</span>';
                content += '<select name="'+id+'_end_time[]" style="width:100px;">';
                <?php
                foreach($time_array as $k=>$v){
                    ?>
                    content += '<option value="<?php echo $k;?>"><?php echo $v;?></option>';
                    <?php
                }
                ?>
                content +='</select>';
                content += '<span>价格:</span>';
                content +='<input type="text" name="'+id+'_d_price[]" value="0" style="width:100px;"/>';
                content += '<a href="javascript:void(0);" onclick="javascript:delItem(this);"><span class="del_ico"></span></a>';
                content += '</p>';
        jQuery("#"+id+"_td").append(content);
    }
    //直接删除页面的内容
    function delItem(obj){
        var td_obj = jQuery(obj).parent().parent();
        jQuery(obj).parent().remove();
        //alert(jQuery(td_obj).html());
        if(jQuery(td_obj).html() == ""){
            jQuery(td_obj).parent().hide();
        }
    }
    //从页面删除，还要从数据库中删除
    function delItemFromDB(obj,id){
        var td_obj = jQuery(obj).parent().parent();
        var url = 'index.php?r=policy/delPolicyDetail';
        jQuery.post(url,{id:id},function(data){
            if(data == 0){
                jQuery(obj).parent().remove();
                //alert(jQuery(td_obj).html());
                if(jQuery(td_obj).html() == ""){
                    jQuery(td_obj).parent().hide();
                }
            }
        });
        
    }
    
    function check(obj,id){
        if(jQuery(obj).attr("checked") == true || jQuery(obj).attr("checked") == 'checked'){
            jQuery("#"+id+"_status").val("1");
        }else{
            jQuery("#"+id+"_status").val("0");
        }
    }
    var flag = true;
    function formSubmit() {
        //checkMyForm();
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
        var desc_obj = jQuery("#remark");
        var ti = "球场简介的内容不超过512个字符";
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
  
    <?php if ($msg['status']) {
        echo "setTimeout(hideMsg,3000);
        ";
        echo "parent.itemQuery();";
    }
    ?>
</script>