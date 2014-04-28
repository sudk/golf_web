<?php
$t->echo_grid_header();
if (is_array($rows))
{
	$j = 1;
        $pay_type = Trip::getPayType();
    foreach ($rows as $i => $row)
    {

	$num = ($curpage-1)*$this->pageSize + $j++;
        
        $link = CHtml::link('详细',"javascript:itemDetail('{$row['id']}')", array());
        $link .= CHtml::link('编辑',"javascript:itemEdit('{$row['id']}')", array());
        $link .= CHtml::link('删除',"javascript:itemDelete('{$row['id']}','{$row['trip_name']}')", array());
        
	$t->echo_td($num); 
        $t->echo_td(htmlspecialchars($row['trip_name'])); //学校编号
        $t->echo_td($pay_type[$row['pay_type']]);
        $t->echo_td($row['start_date']);
        $t->echo_td($row['end_date']);
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