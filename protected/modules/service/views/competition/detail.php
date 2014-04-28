<div id="content">
    <div class="title-box">
        <h1><span style="float:left;">赛事详细信息</span><a href="./?r=service/competition/list" style="float:right;"><span class="ing_ico"></span><span>返回列表</span></a></h1>
    </div>
    <div class="tab-main" id="form-container">
            

<table class="formList">
    <tr>
        <td class="maxname">赛事名称：</td>
        <td class="mivalue">
           <?php
                echo htmlspecialchars($model['name']);
                //echo $form->activeTextField($model, 'facilitie_name', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20,'onblur'=>$checkId), 'required');         
            ?>
        </td>
        <td class="maxname">所在球场：</td>
        <td class="mivalue"><?php 
            echo $model['court_name'];
        ?></td>  
    </tr>
    
    <tr>
        <td class="maxname">开始日期：</td>
        <td class="mivalue">
           <?php
           echo $model['start_date'];
                  ?>
        </td>
        <td class="maxname">结束日期：</td>
        <td class="mivalue"><?php echo $model['end_date']; ?></td>  
    </tr>
    <tr>
        <td class="maxname">支付方式：</td>
        <td class="mivalue">
           <?php
                //echo $model['fee_type'];
                $pay_type = Competition::getType($model['fee_type']);
                echo $pay_type;         
            ?>
        </td>
        <td class="maxname">费用（分）：</td>
        <td class="mivalue"><?php echo $model['fee']; ?></td>  
    </tr>
    
    <tr>
        
        <td class="maxname" style="vertical-align: text-top;">费用包括：</td>
        <td class="mivalue" colspan="3"><?php echo $model['fee_include'];?></td>
    
    </tr>
    <tr>
        
        <td class="maxname" style="vertical-align: text-top;">费用不包括：</td>
        <td class="mivalue" colspan="3"><?php echo $model['fee_not_include'];?></td>
    
    </tr>
    <tr>
        
        <td class="maxname" style="vertical-align: text-top;">赛事内容：</td>
        <td class="mivalue" colspan="3">
            <?php echo $model['plan'];?>
        </td>
    
    </tr>
    <tr>
        
        <td class="maxname" style="vertical-align: text-top;">赛事说明：</td>
        <td class="mivalue" colspan="3"><?php echo $model['desc'];?></td>
    
    </tr>
    <?php
    
    if(@count($model['imgs']) > 0)
    {
        foreach($model['imgs'] as $img_url)
        {
    ?>
    <tr>
        
        <td class="maxname">赛事图片：</td>
        <td class="mivalue" colspan="3">
            <img src="index.php?r=court/loadpic&name=<?php echo $img_url;?>" style="width:100px;"/>
        </td>
    </tr>
    <?php
        }
    }
    ?>
   
</table>


    </div>
</div>