<form name="_query_form" id="_query_form" action="javascript:itemQuery(0);">
    <li>
        <span class="sift-title">搜索：</span>
        <select name="q[status]">
            <option value="">--选择代理商状态--</option>
            <?php
            $status_list = Agent::GetStatus();
            foreach($status_list as $k=>$v)
            {
                echo '<option value="',$key,'">',$v,'</option>';
            }
            ?>
        </select>
        
        <input name="q[agent_name]" type="text" class="grayTips" value="代理商名称"/>
        <input name="q[phone]" type="text" class="grayTips" value="联系电话"/>
        
        <input type="submit" value="" class="search_btn"/>
    </li>
    
</form>
<script type="text/javascript" src="js/JQdate/WdatePicker.js"></script>
<script type="text/javascript">
 		

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