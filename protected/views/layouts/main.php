<style>
    #passwd_easy {
        background-color: #FCFAF1;
        border: 1px solid #FCEFA1;
        clear: both;
        color: #FF9900;
        overflow: hidden;
        padding: 3px 0;
        text-align: center;
    }
</style>
<?php $this->beginContent('//layouts/base'); ?>
<!-- header start -->
<div id="header">
    <div id="header-top">
        <div class="logo"><img src="images/logo.png" /></div>
        <div class="menu">
            <span>你好，<?php echo Yii::app()->user->name;?></span> ｜
            <a href="javascript:void(0)" onclick='tipsWindown("个人信息","iframe:index.php?r=operator/operator/editpri",  "740", "360","true", "","true", "text")' class="b_usredit" id="btnChangePasswd" >个人信息修改</a> ｜
            <a href="./?r=site/logout" class="s_loggoff">安全退出</a>
        </div>
    </div>
    <?php $this->widget('SysMenu', array()); ?>
</div>
<!-- header end -->

<!-- content start -->
<div id="content" class="clearfix">
	<?php echo $content; ?>
</div>
<!-- content end -->

<!-- footer start -->
<div id="footer">Copyright ? 2013 by quick. All Rights Reserved</div>
<!-- footer end -->
<script type="text/javascript">
    jQuery(document).ready(function(){
        // 激活后隐藏输入框文字
        $(function(){
            inputTipText();
        })
    })
</script>
<?php $this->endContent(); ?>
