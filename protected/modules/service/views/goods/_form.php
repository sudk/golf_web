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

$form = $this->beginWidget('SimpleForm', array(
    'id' => 'form1',
    'enableAjaxSubmit' => false,
    'ajaxUpdateId' => 'form-container',
    'focus' => array($model,'id'),
));
?>
<table class="formList">
    <tr>
        <td class="maxname">标题：</td>
        <td class="mivalue"><?php echo htmlspecialchars($model->title); ?></td>
        <td class="maxname">价格：</td>
        <td class="mivalue"><?php echo $model->price;?></td>
    </tr>
    <tr>
        <td class="maxname">所在城市：</td>
        <td class="mivalue">
        <?php
        $city_list = CityCode::getCity();
        echo $model->city?$city_list[$model->city]:"";
        ?>
        </td>
        <td class="maxname">发布时间：</td>
        <td class="mivalue"><?php echo $model->record_time; ?></td>
    </tr>
    <?php
    
    $pic_rows = Img::model()->findAll("relation_id='".$model->id."'");
    
    if(@count($pic_rows)>0)
    {
        foreach($pic_rows as $row)
        {
        ?>
        <tr>
        <td class="maxname">图片：</td>
        <td class="mivalue" colspan="3">
            <img src="index.php?r=court/loadpic&name=<?php echo $row['img_url'];?>" style="width:50px;height:50px"/>
        </td>
        </tr>    
        <?php
        }
    }
    ?>
    <tr>
        <td class="maxname">描述：</td>
        <td class="mivalue" colspan="3">
            <?php echo htmlspecialchars($model->desc);?>
        </td>
        </tr>
        <tr>
        <td class="maxname">状态：</td>
        <td class="mivalue" colspan="3">
            <?php
            $stutus = $model->status;
            echo Flea::GetStatus($stutus);
            
            ?>
        </td>
        </tr>
        <?php
        if($stutus == Flea::STATUS_NORMAL)
        {
            ?>
            <tr>
        <td class="maxname">审核人员：</td>
        <td class="mivalue"><?php echo htmlspecialchars($model->check_id); ?></td>
        <td class="maxname">审核时间：</td>
        <td class="mivalue"><?php echo $model->check_time;?></td>
    </tr>    
            <?php
        }
        if($stutus!= Flea::STATUS_NORMAL)
        {
        ?>
    <tr class="btnBox">
        <td colspan="4">
            <span class="sBtn">
                <a class="left" href="javascript:fleaAudit('<?php echo $model->id;?>');">审核通过</a><a class="right"></a>
            </span>
           
        </td>
    </tr>
    <?php
        }
    ?>
</table>
<?php $this->endWidget();?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        
    });
    
    function fleaAudit(id){
        var url = 'index.php?r=service/goods/audit';
        if(!confirm("确认要审核通过吗？")){return ;}
        $.ajax({
            data:{id:id},
            url:url,
            dataType:"json",
            type:"POST",
            success:function(data){
                if(data.status==0){
                    alert("审核成功！");
                    //itemQuery();
                    window.location.href='index.php?r=service/goods/detail&id='+id;
                }else{
                    alert(data.msg);
                }
            }
        })
    }
    
</script>