<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?= Yii::app()->name ?></title>
        <link href="css/frame_reset.css" rel="stylesheet" type="text/css" />
        <link href="css/frame_layout.css" rel="stylesheet" type="text/css" />
        <link href="css/image.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/login.css" rel="stylesheet" type="text/css" />
        <link href="css/tooltip.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.overall.js"></script>
    </head>
    <body>
        <!-- header start -->
        <div id="header">
            <div id="header-top">
                <div class="logo"><img src="images/logo.png" /></div>
            </div>
            <div id="nav" class="nav nav-nosub" style="margin-top:75px;">
                <div class="nav-cnt">
                    <ul>
                        <li class="master">
                            <a class="name" href="index.php"><strong>首页</strong></a>
                        </li>
                        <li class="master">
                            <a class="name" href="index.php?r=site/apply"><strong>装机在线申请</strong></a>
                        </li>
                        <li class="master current">
                            <a class="name" href="index.php?r=site/applyquery"><strong>申请进度查询</strong></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- header end -->
        <!-- content start -->
        <div id="content">
            <?php $this->renderPartial('_apply_toolBox'); ?>
            <div id="datagrid">
                <?php $this->actionGrid(); ?>
            </div>
        </div>
        <!-- content end -->

        <!-- footer start -->
        <div id="footer">Copyright © 2011 by 创博股份. All Rights Reserved</div>
        <!-- footer end -->

    </body>
</html>