<?php
$t->echo_grid_header();
if (is_array($rows))
{
	$j = 1;
        $trans_type = TransRecord::getTransType();
        $status = TransRecord::getStatus();
    foreach ($rows as $i => $row)
    {

	$num = ($curpage-1)*$this->pageSize + $j++;
        //$t->begin_row("onclick","getDetail(this,'{$row['id']}','{$row['recordtime']}');");
        $t->echo_td($num); 
        $t->echo_td($trans_type[$row['trans_type']]); //学校编号
        $t->echo_td($row['serial_number']);
        $t->echo_td($row['amount']);
        $t->echo_td($row['re_serial_number']);
        $t->echo_td($row['user_id']);
        $t->echo_td($status[$row['status']]);
        
        $t->echo_td($row['record_time']);
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