<?php
$t->echo_grid_header();
if (is_array($rows))
{
	$j = 1;
    $type_list = Order::getOrderType();
    $status_list = Order::getStatus();
    $pay_type = Order::getPayType();
    foreach ($rows as $i => $row)
    {
        $t->begin_row("onclick","getDetail(this,'{$row['order_id']}');");
        $link = "";
        $status = $row['status'];
        $link .= CHtml::link('详细',"javascript:itemLog('{$row['order_id']}')", array());
        if(Yii::app()->user->type == Operator::TYPE_AGENT)
        {
            $link .= CHtml::link('编辑状态',"javascript:itemEdit('{$row['order_id']}')", array());

            if($status == Order::STATUS_TOBE_CANCEL)
            {
                $link .= CHtml::link('删除',"javascript:itemDelete('{$row['order_id']}');", array());
            }
        }
        $status_text = "";
        if($status == Order::STATUS_TOBE_CONFIRM)
        {
            $status_text = '<span style="color:green">'.$status_list[$status].'</span>';
        }else if($status == Order::STATUS_TOBE_PAID)
        {
            $status_text = '<span style="color:blue">'.$status_list[$status].'</span>';
        }
        else if($status == Order::STATUS_TOBE_SUCCESS)
        {
            $status_text = '<span style="color:black">'.$status_list[$status].'</span>';
        }
        else if($status == Order::STATUS_TOBE_CANCEL)
        {
            $status_text = '<span style="color:gray">'.$status_list[$status].'</span>';
        }
        
        $t->echo_td($row['order_id']);
        $t->echo_td($type_list[$row['type']]); //
        $t->echo_td($row['contact']); //
        $t->echo_td($row['relation_name']); //
        $t->echo_td($row['amount']); //
        $t->echo_td($pay_type[$row['pay_type']]); //
        $t->echo_td($status_text); //
        $t->echo_td($row['record_time']); //
        $t->echo_td($link);
        $t->end_row();
    }
}
$t->echo_grid_floor();

$pager = new CPagination($cnt);
$pager->pageSize = $this->pageSize;
$pager->itemCount = $cnt;
?>
<div class="page">
    <div class="floatL">共 <strong><?php echo $cnt; ?></strong>&nbsp;条</div>
    <div class="pageNumber">
<?php $this->widget('AjaxLinkPager', array('bindTable' => $t, 'pages' => $pager)); ?>
    </div>
</div>
<div class="alternate-rule" style="display: none;"></div>