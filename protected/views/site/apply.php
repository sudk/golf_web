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
                        <li class="master current">
                            <a class="name" href="index.php?r=site/apply"><strong>装机在线申请</strong></a>
                        </li>
                        <li class="master">
                            <a class="name" href="index.php?r=site/applyquery"><strong>申请进度查询</strong></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- header end -->
        <!-- content start -->
        <div id="content">
            <?php
            if ($result['notice'] != '') {
                echo "<div class='notice'>" . $result['notice'] . "</div>";
            } else if ($result['message'] != '') {
                echo "<div class='success'>" . $result['message'] . "</div>";
            } else if ($result['error'] != '') {
                echo "<div class='error'>" . $result['error'] . "</div>";
            }
            $form = $this->beginWidget('SimpleForm', array(
                'id' => 'form1',
                'enableAjaxSubmit' => false,
                'ajaxUpdateId' => 'form-container',
                'focus' => array($model, mchtname),
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    ));
            ?>
            <table class="formList" >
                <tr>
                    <td class="maxname"><span class="colRed mr5">*</span>商户名称：</td>
                    <td class="mivalue"><?php echo $form->activeTextField($model, 'mchtname', array('title' => '本项必填', 'class' => 'input_text'), 'required'); ?></td>
                    <td class="maxname"><span class="colRed mr5">*</span>联系人：</td>
                    <td class="mivalue"><?php echo $form->activeTextField($model, 'contacter', array('title' => '本项必填', 'class' => 'input_text'), 'required'); ?></td>
                </tr>
                <tr>
                    <td class="maxname"><span class="colRed mr5">*</span>身份证号：</td>
                    <td class="mivalue"><?php echo $form->activeTextField($model, 'repnum', array('title' => '本项必填', 'class' => 'input_text'), 'required&idcard'); ?></td>
                    <td class="maxname">电话：</td>
                    <td class="mivalue"><?php echo $form->activeTextField($model, 'tel', array('class' => 'input_text', 'maxlength' => 12), 'number'); ?></td>
                </tr>
                <tr>
                    <td class="maxname"><span class="colRed mr5">*</span>手机：</td>
                    <td class="mivalue"><?php echo $form->activeTextField($model, 'celphone', array('title' => '本项必填', 'class' => 'input_text', 'maxlength' => 11), 'required'); ?></td>
                    <td class="maxname"><span class="colRed mr5">*</span>所属省份：</td>
                    <td class="mivalue"><?php echo $form->activeDropDownList($model, 'province', DistrictCode::GetProvince(), array('title' => '本项必填', 'class' => 'input_text', 'disabled' => 'true'), 'required'); ?></td>
                </tr>
                <tr>
                    <td class="maxname"><span class="colRed mr5">*</span>所属城市：</td>
                    <td class="mivalue"><?php echo $form->activeDropDownList($model, 'city', DistrictCode::GetCity(Yii::app()->params['default_province']), array('class' => 'input_text'), 'required'); ?></td>
                    <td class="maxname"><span class="colRed mr5">*</span>所属地区：</td>
                    <td class="mivalue"><?php echo $form->activeDropDownList($model, 'area', DistrictCode::GetArea($model->city ? $model->city : Yii::app()->params['default_city']), array('title' => '本项必填', 'class' => 'input_text', 'style' => 'width:300px;'), 'required'); ?></td>
                </tr>
                <tr>
                    <td class="maxname">地址：</td>
                    <td class="mivalue"><?php echo $form->activeTextField($model, 'mchtaddr', array('class' => 'input_text address'), ''); ?></td>
                </tr>
                <tr>
                    <td class="maxname">营业执照：</td>
                    <td calss="mivalue">
                        <input type="file" name="file_license"/>&nbsp;请上传2m以内jpg、png图片
                    </td>
                </tr>
                <tr>
                    <td class="maxname">税务登记证：</td>
                    <td calss="mivalue">
                        <input type="file" name="file_tax"/>&nbsp;请上传2m以内jpg、png图片
                    </td>
                </tr>
                <tr>
                    <td class="maxname">组织机构代码证：</td>
                    <td calss="mivalue">
                        <input type="file" name="file_org"/>&nbsp;请上传2m以内jpg、png图片
                    </td>
                </tr>
                <tr>
                    <td class="maxname">开户许可证：</td>
                    <td calss="mivalue">
                        <input type="file" name="file_open"/>&nbsp;请上传2m以内jpg、png图片
                    </td>
                </tr>
                <tr>
                    <td class="maxname"><span class="colRed mr5">*</span>验证码：</td>
                    <td class="mivalue">
                        <input type="text" class="input_text" style="width:80px;" name="Install[captcha]" id="captcha" maxlength="4" validator="required" title="本项必填"/>
                        <img src="index.php?r=site/captcha&1254274355" style="vertical-align:middle;width:56px;height: 28px;" alt="验证码"/>
                </tr>
                <tr class="btnBox">
                    <td colspan="4">
                        <span class="sBtn">
                            <a id="btnSubmit" class="left">保存</a><a class="right"></a>
                        </span>
                        <span class="sBtn-cancel">
                            <a id="btnReset" class="left">重置</a><a class="right"></a>
                        </span>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
            <link rel="stylesheet" type="text/css" href="js/JQwindow/windowCSS.css"/>
            <script type="text/javascript" src="js/JQwindow/windowJS.js"></script>
            <!-- jquery 上传控件 start -->
            <script type="text/javascript" src="js/JQupload/jquery.uploadify.min.js"></script>
            <script type="text/javascript" src="js/jquery.min.js"></script>
            <link rel="stylesheet" type="text/css" href="js/JQupload/uploadify.css"/>
            <!-- jquery 上传控件 end-->
            <script type="text/javascript">
                
                jQuery("#btnSubmit").click(function () {
                    $("#form1").submit();
                });
                jQuery("#btnReset").click(function () {
                    $("#form1").reset();
                });
        
<?php $timestamp = time(); ?>
    $(function() {
        $('#file_upload').uploadify({
            'formData'     : {
                'timestamp' : '<?php echo $timestamp; ?>',
                'token'     : '<?php echo md5('unique_salt' . $timestamp); ?>'
            },
            'swf'      : 'uploadify.swf',
            'uploader' : 'uploadify.php'
        });
    });
            </script>

            <script type="text/javascript">
               
                /**
                 * 城市-地区联动
                 */
                $("#Install_city").change(function () {
                    var cityid = $("#Install_city").val();
                    loadAreas(cityid);
                });

                function loadAreas(id) {
                    
                    $.ajax({
                        type:"POST",
                        url:"./?r=site/queryarea",
                        data:"&cityid=" + id,
                        dataType:'json',
                        timeout:5000,
                        error:function () {
                            alert('加载失败!');
                        },
                        success:function (m) {
                            var dataObj = m;
                            var areaid = "<?php echo $model->area; ?>";
                            $("#Install_area").empty();
                            $.each(dataObj, function (key, val) {
                                //回调函数有两个参数,第一个是元素索引,第二个为当前值
                                if (areaid == key) {
                                    $("#Install_area").append("<option value='" + key + "' selected>" + val + "</option>");
                                } else {
                                    $("#Install_area").append("<option value='" + key + "'>" + val + "</option>");
                                }

                            });
                        }
                    });
                  
    
                }
            </script>

        </div>
        <!-- content end -->

        <!-- footer start -->
        <div id="footer">Copyright © 2011 by 创博股份. All Rights Reserved</div>
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
            $('.getpass').show();
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
        $('#getPasswd').click(function(){
            var username = $('#userName').val();
            var captcha = $('#captcha').val();
            if(username == '') {
                alert('用户名不能为空！');
                $('#userName').focus();
                return false;
            }
            if(captcha == '') {
                alert('验证码不能为空！');
                $('#captcha').focus();
                return false;
            }
            $.ajax({
                url: "index.php?r=site/getpass&username="+username+"&captcha="+captcha,
                context: document.body,
                success: function(data, textStatus){
                    alert(data);
                }
            });
        })
    });
</script>
