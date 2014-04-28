<?php
$t->echo_grid_header();
if (is_array($rows))
{
	$j = 1;
    foreach ($rows as $i => $row)
    {
        //$t->begin_row("onclick","getDetail(this,'{$row['id']}');");
	
        $link = CHtml::link('编辑',"javascript:itemEdit('{$row['id']}')", array());
        
        $link .= CHtml::link('删除',"javascript:itemDelete('{$row['id']}','{$row['agent_name']}')", array());
	
        
        $t->echo_td($row['agent_name']); //
        $t->echo_td($row['contactor']);
        $t->echo_td($row['phone']);
        $t->echo_td($row['extra']);
        $t->echo_td(Agent::GetStatus($row['status']));
        $t->echo_td($row['record_time']);
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