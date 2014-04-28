<form name="_query_form" id="_query_form"  action="index.php?r=site/applyquery" method="post">
    <ul class="sift">
        <li>
            <span class="sift-title">搜索：</span>
            <select name="q_by">
                <option value="repnum">身份证号</option>
                <option value="tel">电话</option>
                <option value="celphone">手机号</option>
            </select>
            <input name="q_value" type="text" class="grayTips" value="<?=$_POST['q_value'];?>"/>
        </li>
        <li>
            <span class="sift-title">验证码：</span>
            <input name="captcha" type="text" class="grayTips" />
            <span style="float:left; margin:0 5px; margin-top:-3px;"><img src="index.php?r=site/captcha&1254274355" style="vertical-align:middle;width:56px;height: 25px;" alt="验证码"/></span>
            <input type="submit" value="" class="search_btn"/>
        </li>
    </ul>
    <input type="hidden" name="query" value="1"/>
</form>
