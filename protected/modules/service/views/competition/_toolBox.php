<form name="_query_form" id="_query_form" action="javascript:itemQuery(0);">
    <li>
        <span class="sift-title">搜索：</span>
        <?php
        if(Yii::app()->user->type == Operator::TYPE_SYS)
        {
        ?>
        <select name="q[agent_id]" >
            <option value="">--选择代理商--</option>
            <?php
            $agent_list = Agent::getAgentList();
            foreach($agent_list as $k=>$v)
            {
                echo '<option value="',$k,'">',$v,'</option>';
            }
            ?>
        </select>
        <?php
        }else{
            echo '<input type="hidden" name="q[agent_id]" value="',Yii::app()->user->agent_id,'"/>';
        }
        ?>
        <span style="float:left; margin:0 5px; margin-top:-3px;">&nbsp;</span>
        <select name="q[court_id]" >
            <option value="">--选择举办赛事的球场--</option>
            <?php
            $court_list = Court::getCourtArray();
            foreach($court_list as $k=>$v)
            {
                echo '<option value="',$k,'">',$v,'</option>';
            }
            ?>
        </select>
        <span style="float:left; margin:0 5px; margin-top:-3px;">&nbsp;</span>
        <input name="q[name]" type="text" class="grayTips" value="赛事名称"/>
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