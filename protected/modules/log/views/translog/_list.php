<?php
$t->echo_grid_header();
if (is_array($rows))
{
	$j = 1;
    foreach ($rows as $i => $row)
    {

		$num = ($curpage-1)*$this->pageSize + $j++;	
		$type = $row['type']?Translog::GetType($row['type']):'';	
		
		$t->echo_td($num); 
        $t->echo_td($row['mchtid']); //学校编号
        $t->echo_td($row['settdate']);
        $t->echo_td($row['desc']);
        $t->echo_td($type);
        $t->echo_td($row['recordtime']);
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