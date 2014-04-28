<?php
$t->echo_grid_header();
if (is_array($rows))
{
	$j = 1;

    $status_list = Order::getStatus();
    $opt_type = OrderLog::getOptType();
    foreach ($rows as $i => $row)
    {
        //$t->begin_row("onclick","getDetail(this,'{$row['order_id']}');");
        $num = ($curpage-1)*$this->pageSize + $j++;
        $status = $row['status'];
        
        
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
        
        $t->echo_td($num);
        $t->echo_td($row['record_time']); //
        $t->echo_td($row['order_id']); //
        $t->echo_td($status_text); //
        $t->echo_td($row['operator_id']); //
        $t->echo_td($opt_type[$row['operator_type']]); //
        $t->echo_td($row['serial_number']); //
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