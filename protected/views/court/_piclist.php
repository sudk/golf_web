<?php
$t->echo_grid_header();
if (is_array($rows))
{
    $type_list = Img::getType();
    foreach ($rows as $i => $row)
    {
        //$t->begin_row("onclick","getDetail(this,'{$row['court_id']}');");
	
        $link = "";
        if(Yii::app()->user->type == Operator::TYPE_SYS)
        {
            $link .= CHtml::link('删除',"javascript:itemDelete('{$row['id']}');", array());
        }
        $url = "index.php?r=court/loadpic&name=".$row['img_url'];
        $img = '<img src="'.$url.'" style="width:50px;height:50px;"/>';
        $t->echo_td($type_list[$row['type']]);
        $t->echo_td($img); //
      
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