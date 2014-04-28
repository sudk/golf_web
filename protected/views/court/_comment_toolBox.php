<form name="_query_form" id="_query_form" action="javascript:itemQuery(0);">
    <li>
        <span class="sift-title">搜索：</span>
        
        
        <?php
        if(isset($cur_court_id)){
            ?>
                <input type="hidden" name="q[court_id]" value="<?php echo $cur_court_id;?>"/>
                <?php
        }else{
        ?>
        <span style="float:left; margin:0 3px; margin-top:-3px;">球场名称</span>
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
        <?php
        }
        ?>
       <span style="float:left; margin:0 3px; margin-top:-3px;">查询日期</span>
        <input id="begintime"  type="text" name="q[begin_date]" size="14" class="Wdate" value="<?php echo date('Y-m-d');?>" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',skin:'whyGreen',errDealMode:0})" >
        <span style="float:left; margin:0 5px; margin-top:-3px;">到</span>
        <input id="endtime"  type="text" name="q[end_date]"  size="14" class="Wdate"  value="<?php echo date('Y-m-d');?>" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',skin:'whyGreen',errDealMode:0})" >
       
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
            <?=$this->cGridId?>.page = arguments[0];
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
<?php echo $this->cGridId; ?>.condition = url;
<?php echo $this->cGridId; ?>.refresh();
    }

</script>