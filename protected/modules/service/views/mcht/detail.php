<div id="content">
    <div class="title-box">
        <h1><span style="float:left;">商户详细信息</span><a href="./?r=service/mcht/list" style="float:right;"><span class="ing_ico"></span><span>返回列表</span></a></h1>
    </div>
    <div class="tab-main" id="form-container">
            

<table class="formList">
    <tr>
        <td class="maxname">商户名称：</td>
        <td class="mivalue">
           <?php
                echo htmlspecialchars($model->facilitie_name);
                //echo $form->activeTextField($model, 'facilitie_name', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20,'onblur'=>$checkId), 'required');         
            ?>
        </td>
        <td class="maxname">商户类型：</td>
        <td class="mivalue"><?php 
        $type_list = CourtFacilities::getType();
        echo $type_list[$model->type]; 
        ?></td>  
    </tr>
    
    <tr>
        <td class="maxname">附近球场：</td>
        <td class="mivalue">
           <?php
          $court_list =  Court::getCourtArray();
          echo $court_list[$model->court_id];
                  ?>
        </td>
        <td class="maxname">电话：</td>
        <td class="mivalue"><?php echo $model->phone; ?></td>  
    </tr>
    <tr>
        <td class="maxname">地址：</td>
        <td class="mivalue">
           <?php
                echo $model->addr;         
            ?>
        </td>
        <td class="maxname">人均消费：</td>
        <td class="mivalue"><?php echo $model->consumption; ?></td>  
    </tr>
    
    <tr>
        <td class="maxname">绿卡优惠：</td>
        <td class="mivalue">
           <?php
                echo $model->favourable;
                ?>
        </td>
        <td class="maxname">距球场距离：</td>
        <td class="mivalue"><?php echo $model->distance; ?></td>  
    </tr>
    
    <tr>
        
        <td class="maxname">特色：</td>
        <td class="mivalue" colspan="3"><?php echo $model->feature;?></td>
    
    
    <?php
    //var_dump($model->id);
    $row = Img::model()->find("relation_id='".$model->id."' and type='2'");
    //var_dump($row);
    if($row!=null)
    {
    ?>
    <tr>
        
        <td class="maxname">图片：</td>
        <td class="mivalue" colspan="3">
            <img src="index.php?r=court/loadpic&name=<?php echo $row['img_url'];?>" style="width:100px;"/>
        </td>
    </tr>
    <?php
    }
    ?>
   
</table>


    </div>
</div>