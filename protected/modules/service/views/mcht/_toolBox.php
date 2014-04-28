<form name="_query_form" id="_query_form" action="javascript:itemQuery(0);">
    <li>
        <span class="sift-title">搜索：</span>
        <select name="q[type]" >
            <option value="">--选择商户类型--</option>
            <?php
            $type_list = CourtFacilities::getType();
            foreach($type_list as $k=>$v)
            {
                echo '<option value="',$k,'">',$v,'</option>';
            }
            ?>
        </select>
        <span style="float:left; margin:0 5px; margin-top:-3px;">&nbsp;</span>
        <select name="q[court_id]" >
            <option value="">--选择附近的球场--</option>
            <?php
            $court_list = Court::getCourtArray();
            foreach($court_list as $k=>$v)
            {
                echo '<option value="',$k,'">',$v,'</option>';
            }
            ?>
        </select>
        <span style="float:left; margin:0 5px; margin-top:-3px;">&nbsp;</span>
        <input name="q[facilite_name]" type="text" class="grayTips" value="商户名称"/>
        <input type="submit" value="" class="search_btn" />
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