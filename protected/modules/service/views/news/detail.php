<div id="content">
    <div class="title-box">
        <h1><span style="float:left;">新闻详细信息</span><a href="./?r=service/news/list" style="float:right;"><span class="ing_ico"></span><span>返回列表</span></a></h1>
    </div>
    <div class="tab-main" id="form-container">
            

<table class="formList">
    <tr>
        <td class="maxname">标题：</td>
        <td class="mivalue" colspan="3">
           <?php
                echo htmlspecialchars($model['title']);
                //echo $form->activeTextField($model, 'facilitie_name', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 20,'onblur'=>$checkId), 'required');         
            ?>
        </td>
       
    </tr>
 
    <tr>
        
        <td class="maxname" style="vertical-align: text-top;">新闻内容：</td>
        <td class="mivalue" colspan="3">
            <div style="width: 500px;"><?php echo $model['content'];?>
            </div>
            </td>
    
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