<div class="title-box">
    <h1><span style="float:left;">订单详细.[订单编号：<?php  echo $order_id;?>]</span><a href="./?r=order/list" style="float:right;"><span class="ing_ico"></span><span>返回列表</span></a></h1>
    <ul class="sift">
        <?php //$this->renderPartial('_toolBox',array('order_id'=>$order_id)); ?>
    </ul>
</div>
<div id="datagrid">
    <?php $this->actionLGrid(); ?>
</div>
<style type="text/css">
    #row_desc span{
        color: #808080;
    }
</style>
<script type="text/javascript">
 
</script>