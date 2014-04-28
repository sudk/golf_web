<form name="_query_form" id="_query_form" action="javascript:itemQuery(0);">
    <li>
        <span class="sift-title">搜索：</span>
        <?php
        if(Yii::app()->user->type == Operator::TYPE_SYS){
            ?>
            <span style="float:left; margin:0 3px; margin-top:-3px;">代理商</span>
        <select name="q[agent_id]">
            <option value="">--选择--</option>
            <?php
            $agent_list = Agent::getAgentList();
            if(@count($agent_list) > 0 )
            {
                foreach($agent_list as $key=>$value)
                {
                    echo '<option value="'.$key.'">'.$value.'</option>';
                }
            }
            ?>
        </select>    
            <?php
        }
        ?>
        <span style="float:left; margin:0 3px; margin-top:-3px;">订单类型</span>
        <select name="q[order_type]">
            <option value="">--选择--</option>
            <?php
            $type_list = Order::getOrderType();
            if(@count($type_list) > 0 )
            {
                foreach($type_list as $key=>$value)
                {
                    echo '<option value="'.$key.'">'.$value.'</option>';
                }
            }
            ?>
        </select>
        <span style="float:left; margin:0 3px; margin-top:-3px;">订单状态</span>
        <select name="q[status]">
            <option value="">--选择--</option>
            <?php
            $status_list = Order::getStatus();
            if(@count($status_list) > 0 )
            {
                foreach($status_list as $key=>$value)
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