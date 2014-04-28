<?php
    $type = isset($_POST['LoginForm']['type'])? intval($_POST['LoginForm']['type']):1;
?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=Yii::app()->name?></title>
    <link href="css/frame_reset.css" rel="stylesheet" type="text/css" />
    <link href="css/frame_layout.css" rel="stylesheet" type="text/css" />
    <link href="css/image.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/login.css" rel="stylesheet" type="text/css" />
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
                <li class="master current">
                    <a class="name" href="#"><strong>首页</strong></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- header end -->
<!-- content start -->
<div id="content" class="login">
    <div class="login_left">
        <img src="images/login/ad_1.jpg" id="ad" />
    </div>
    <form action="index.php?r=site/login" method="post" id="loginForm">
    <div class="login_right">
        <div class="title">
            <a>管理员登录</a>
        </div>
        <ul class="login_box">
            <?php
            if($message != '')
                echo '<li class="error_msg">'.$message.'</li>';
            ?>
            <li>
                <span class="name">用户名</span>
                <input type="text" class="input_text" name="LoginForm[username]" id="userName" value=""/>
            </li>
            <li>
                <span class="name">密&nbsp;&nbsp;&nbsp;码</span>
                <input type="password" class="input_text"  name="LoginForm[passwd]" id="userPwd"/>
            </li>
            <li>
                <span class="name">验证码</span>
                <input type="text" class="input_text" style="width:80px;" name="LoginForm[captcha]" id="captcha" maxlength="4"/>
                <img src="index.php?r=site/captcha&1254274355" style="vertical-align:middle;width:56px;height: 28px;" />
                <a href="#" style="display: none;">换一张</a>
            </li>
            <li class="btnBox">
                <span class="sBtn">
                    <a class="left" id="btnSubmit">登录</a><a class="right"></a>
                </span>
                <span style="margin-left: 5px;display: none;" class="getpass">
                    <a href="#" id="getPasswd" style="margin-top: 15px;padding-top: 20px;">忘记密码</a>
                </span>
            </li>
        </ul>
    </div>
    </form>
</div>
<!-- content end -->

<!-- footer start -->
<div id="footer">Copyright © 2011 by quick. All Rights Reserved</div>
<!-- footer end -->
</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        $('#tab_1').click(function(){
            $(this).addClass('air_1');
            $('#tab_2').removeClass('air_2');
            //$('#ad').attr('src','images/login/ad_1.jpg');
            $('#userType').attr('value','2');
            //$('.getpass').show();
        })
        $('#tab_2').click(function(){
            $(this).addClass('air_2');
            $('#tab_1').removeClass('air_1');
            //$('#ad').attr('src','images/login/ad_2.jpg');
            $('#userType').attr('value','1');
            $('.getpass').hide();
        })
        $('#btnSubmit').click(function(){
            $('#loginForm').submit();
        })
        $('input:text:first').focus();
        $('input').live("keypress", function(e) {
            /* ENTER PRESSED*/
            if (e.keyCode == 13) {
                /* FOCUS ELEMENT */
                var inputs = $(this).parents("form").eq(0).find(":input");
                var idx = inputs.index(this);

                if($(this).attr("name")=='LoginForm[captcha]') { //if (idx == inputs.length - 1) { // if($(this).attr("name")=='submit') {
                    //inputs[0].select();
                    $('#loginForm').submit();
                    return true;
                } else {
                    inputs[idx + 1].focus(); //  handles submit buttons
                    inputs[idx + 1].select();
                }
                return false;
            }
        });

    });
</script>
