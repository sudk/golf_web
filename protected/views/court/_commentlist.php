<?php
$t->echo_grid_header();
if (is_array($rows))
{
    foreach ($rows as $i => $row)
    {
        //$t->begin_row("onclick","getDetail(this,'{$row['court_id']}');");
	
        //$link = "";
        //$link .= CHtml::link('删除',"javascript:itemDelete('{$row['id']}');", array());
        $desc = $row['desc'];
        $sub_desc = mb_substr($desc,0,5,'UTF-8')."...";
        $desc_text = '<span title="'.$desc.'">'.$sub_desc.'</span>';
        $t->echo_td($row['court_name']);
        $t->echo_td($row['service']); //
        $t->echo_td($row['design']); //
        $t->echo_td($row['facilitie']);
        $t->echo_td($row['lawn']); //
        $t->echo_td($row['user_id']); //
        $t->echo_td($row['record_time']); //
        $t->echo_td($desc_text); //
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