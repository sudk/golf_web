<form name="_query_form" id="_query_form" action="javascript:itemQuery(0);">
    <li>
        <span class="sift-title">搜索：</span>
        <select name="q_by">
            <option value="card_no">会员卡号</option>
            <option value="user_name">会员姓名</option>
            <option value="phone">手机号</option>
        </select>
        <input name="q_value" type="text" class="grayTips" />
        <span style="float:left; margin:0 3px; margin-top:-3px;">所在球场</span>
        <select name="q[court_id]">
            <option value="">--选择--</option>
            <?php
            $court_list = Court::getCourtArray();
            if(@count($court_list) > 0 )
            {
                foreach($court_list as $key=>$value)
                {
                    echo '<option value="'.$key.'">'.$value.'</option>';
                }
            }
            ?>
        </select>
        
        <input type="submit" value="" class="search_btn"/>
    </li>
</form>
<script type="text/javascript" src="js/JQdate/WdatePicker.js"></script>
<script type="text/javascript">
 		jQuery(document).ready(function(){
             
  }); 

    var itemQuery = function(){
        var length=arguments.length;
        if(length==1){
            <?=$this->gridId?>.page = arguments[0];
        }
        var objs = document.getElementById("_query_form").elements;
        var i = 0;
        var cnt = objs.length;
        var obj;
        var url = '';
        for (i = 0; i < cnt; i++) {
            obj = objs.item(i);
            url += '&' + obj.name + '=' + obj.value;
        }
<?php echo $this->gridId; ?>.condition = url;
<?php echo $this->gridId; ?>.refresh();
    }

</script>