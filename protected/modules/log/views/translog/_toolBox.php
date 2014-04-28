<form name="_query_form" id="_query_form" action="javascript:itemQuery(0);">
	<input type="hidden" name="q[areacode]" id="qareacode" value=''/>
    <li>
        <span class="sift-title">搜索：</span>
        <span style="float:left; margin:0 3px; margin-top:-3px;">清算日期从</span>
        <input id="startdate" class="Wdate" type="text" name="q[startdate]" size="14" value="<?php echo date("Y-m-d",strtotime('-1 day'))?>" onfocus="WdatePicker({maxDate:'<?php echo date("Y-m-d",strtotime('-1 day'))?>',dateFmt:'yyyy-MM-dd',skin:'whyGreen',errDealMode:0})" >
        <span style="float:left; margin:0 5px; margin-top:-3px;">到</span>
        <input id="enddate" class="Wdate" type="text" name="q[enddate]"  size="14"  value="<?php echo date("Y-m-d",strtotime('-1 day'))?>" onfocus="WdatePicker({maxDate:'<?php echo date("Y-m-d",strtotime('-1 day'))?>',dateFmt:'yyyy-MM-dd',skin:'whyGreen',errDealMode:0})" >
        <span style="float:left; margin:0 5px; margin-top:-3px;">&nbsp;</span>
        <select name="q_by">
            <option value="mchtid">商户编号</option>
        </select>
        <input name="q_value" type="text" class="grayTips" />
        <input type="submit" value="" class="search_btn" />
    </li>
</form>
<script type="text/javascript" src="js/JQdate/WdatePicker.js"></script>
<script type="text/javascript">
 		jQuery(document).ready(function(){
        //当前月份
        jQuery($("a[name='qareacode[]']")).click(function(){
            var qvalue = jQuery(this).attr("qvalue");
            if(qvalue != '')
            {
                jQuery("#qareacode").attr("value",qvalue);
            }else{
                jQuery("#qareacode").attr("value","");
            }
            jQuery($("a[name='qareacode[]']")).removeClass('air');
            jQuery(this).addClass('air');
            itemQuery(0);
        });
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