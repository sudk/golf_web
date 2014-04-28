<?php
if ($result['error'] != '') {
    echo "<div class='error'>" . $result['error'] . "</div>";
} else {
    $t->echo_grid_header();
    if (is_array($rows)) {
        $j = 1;
        foreach ($rows as $i => $row) {
            $t->echo_td(mb_substr($row['mchtname'], 0, 12, 'utf-8'));
            $t->echo_td($row['contacter']); //法人代表
            $t->echo_td(Utils::markIdNumber($row['repnum'])); //身份证号
            $t->echo_td($row['tel']); //电话
            $t->echo_td(Utils::markPhone($row['celphone'])); //手机
            $t->echo_td($row['recordtime']); //登录时间
            $d = Install::getStatus($row['status']); //状态
            $t->echo_td($d['desc']);
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
<?php
}

?>
<div class="alternate-rule" style="display: none;"></div>