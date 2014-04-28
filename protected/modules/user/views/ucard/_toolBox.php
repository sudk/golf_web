<form name="_query_form" id="_query_form" action="javascript:itemQuery(0);">
    <li>
        <span class="sift-title">搜索：</span>
        <select name="q_by">
            <option value="id">编号</option>
            <option value="name">姓名</option>
        </select>
        <input type="hidden" name="q[type]" id="qtype" value=''/>
        <input type="hidden" name="q[pin]" id="qpin" value=''/>
        <input name="q_value" type="text" class="grayTips" />
        <input type="submit" value="" class="search_btn"/>
    </li>
    <li>
        <span class="sift-title">拼音：</span>
        <?php
        echo CHtml::link('不限', '', array('class' => 'air', 'name' => 'qpin[]', 'qvalue' =>''));
        echo CHtml::link( "a", '', array('qvalue'=> "a", 'name' => 'qpin[]'));
        echo CHtml::link( "b", '', array('qvalue'=> "b", 'name' => 'qpin[]'));
        echo CHtml::link( "c", '', array('qvalue'=> "c", 'name' => 'qpin[]'));
        echo CHtml::link( "d", '', array('qvalue'=> "d", 'name' => 'qpin[]'));
        echo CHtml::link( "e", '', array('qvalue'=> "e", 'name' => 'qpin[]'));
        echo CHtml::link( "f", '', array('qvalue'=> "f", 'name' => 'qpin[]'));
        echo CHtml::link( "g", '', array('qvalue'=> "g", 'name' => 'qpin[]'));
        echo CHtml::link( "h", '', array('qvalue'=> "h", 'name' => 'qpin[]'));
        echo CHtml::link( "i", '', array('qvalue'=> "i", 'name' => 'qpin[]'));
        echo CHtml::link( "j", '', array('qvalue'=> "j", 'name' => 'qpin[]'));
        echo CHtml::link( "k", '', array('qvalue'=> "k", 'name' => 'qpin[]'));
        echo CHtml::link( "l", '', array('qvalue'=> "l", 'name' => 'qpin[]'));
        echo CHtml::link( "n", '', array('qvalue'=> "n", 'name' => 'qpin[]'));
        echo CHtml::link( "m", '', array('qvalue'=> "m", 'name' => 'qpin[]'));
        echo CHtml::link( "o", '', array('qvalue'=> "o", 'name' => 'qpin[]'));
        echo CHtml::link( "p", '', array('qvalue'=> "p", 'name' => 'qpin[]'));
        echo CHtml::link( "q", '', array('qvalue'=> "q", 'name' => 'qpin[]'));
        echo CHtml::link( "r", '', array('qvalue'=> "r", 'name' => 'qpin[]'));
        echo CHtml::link( "s", '', array('qvalue'=> "s", 'name' => 'qpin[]'));
        echo CHtml::link( "t", '', array('qvalue'=> "t", 'name' => 'qpin[]'));
        echo CHtml::link( "u", '', array('qvalue'=> "u", 'name' => 'qpin[]'));
        echo CHtml::link( "v", '', array('qvalue'=> "v", 'name' => 'qpin[]'));
        echo CHtml::link( "w", '', array('qvalue'=> "w", 'name' => 'qpin[]'));
        echo CHtml::link( "x", '', array('qvalue'=> "x", 'name' => 'qpin[]'));
        echo CHtml::link( "y", '', array('qvalue'=> "y", 'name' => 'qpin[]'));
        echo CHtml::link( "z", '', array('qvalue'=> "z", 'name' => 'qpin[]'));
        ?>
    </li>
</form>
<script type="text/javascript" src="js/JQdate/WdatePicker.js"></script>
<script type="text/javascript">
 		jQuery(document).ready(function(){
             //当前月份
             jQuery($("a[name='qtype[]']")).click(function () {
                 var qvalue = jQuery(this).attr("qvalue");
                 if (qvalue != '') {
                     jQuery("#qtype").attr("value", qvalue);
                 } else {
                     jQuery("#qtype").attr("value", "");
                 }
                 jQuery($("a[name='qtype[]']")).removeClass('air');
                 jQuery(this).addClass('air');
                 itemQuery(0);
             });
             //当前月份
             jQuery($("a[name='qpin[]']")).click(function () {
                 var qvalue = jQuery(this).attr("qvalue");
                 if (qvalue != '') {
                     jQuery("#qpin").attr("value", qvalue);
                 } else {
                     jQuery("#qpin").attr("value", "");
                 }
                 jQuery($("a[name='qpin[]']")).removeClass('air');
                 jQuery(this).addClass('air');
                 itemQuery(0);
             })
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