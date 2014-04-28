<?php
$t->echo_grid_header();
if (is_array($rows))
{
    $type_list = Img::getType();
    foreach ($rows as $i => $row)
    {
        //$t->begin_row("onclick","getDetail(this,'{$row['court_id']}');");
	$service_text = "";
        $price_text = "";
        $mon_price = "";
        $tun_price = "";
        $wed_price = "";
        $thu_price = "";
        $fri_price = "";
        $sat_price = "";
        $sun_price = "";
        
        //服务项目
        $service_text .= $row['is_green']==Policy::IS_YES?"18洞果岭,":"";
        $service_text .= $row['is_caddie']==Policy::IS_YES?"球童,":"";
        $service_text .= $row['is_car']==Policy::IS_YES?"球车,":"";
        $service_text .= $row['is_wardrobe']==Policy::IS_YES?"衣柜,":"";
        $service_text .= $row['is_insurance']==Policy::IS_YES?"小费,":"";

        //获取周的每天的默认报价
        $policy_id = $row['id'];
        $sql = "policy_id='".$policy_id."' and start_time='' and end_time=''";

        $sql = $sql." and day='-1'";
        $d_row = PolicyDetail::model()->find($sql);
        $price = "";
        if($d_row)
        {
            $price = $d_row['price'];
        }

        
        $link = "";
        $link .= CHtml::link('编辑',"javascript:itemEdit('{$row['id']}','2');", array());
        $link .= CHtml::link('删除',"javascript:itemDelete('{$row['id']}');", array());
        
        $t->echo_td($row['start_date']);
        $t->echo_td($row['end_date']); //
        $t->echo_td($service_text);
        $t->echo_td($row['remark']); //
        $t->echo_td($row['cancel_remark']);
        $t->echo_td($price); //
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