<form name="_query_form" id="_query_form" action="javascript:itemQuery(0);">
    <li>
        <span class="sift-title">搜索：</span>
        
        
        <span style="float:left; margin:0 3px; margin-top:-3px;">球场</span>
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
        
        <span style="float:left; margin:0 3px; margin-top:-3px;">查询月份</span>
        <input id="month" class="Wdate" type="text" name="q[month]" size="14" value="<?php echo date("Y-m")?>" onfocus="WdatePicker({dateFmt:'yyyy-MM',skin:'whyGreen',errDealMode:0})" >
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