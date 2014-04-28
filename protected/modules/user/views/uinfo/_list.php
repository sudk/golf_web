<?php
$t->echo_grid_header();
if (is_array($rows))
{
	
    
    foreach ($rows as $i => $row)
    {
        
        $t->begin_row("onclick","getDetail(this,'{$row['user_id']}');");
	
        $link = CHtml::link('编辑',"javascript:itemEdit('{$row['user_id']}')", array());
        //$link .= CHtml::link('删除',"javascript:itemDelete('{$row['user_id']}','{$row['user_name']}')", array());
	
        $link .= CHtml::link('重置密码',"javascript:itemResetPwd('{$row['user_id']}','{$row['user_name']}')", array());
	
      
        $t->echo_td($row['user_name']); //
        $t->echo_td($row['phone']);
        $t->echo_td($row['card_no']);
        $t->echo_td($row['balance']);
        $t->echo_td($row['point']);
        $t->echo_td($row['city']);
        $t->echo_td(User::GetStatus($row['status']));
       
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