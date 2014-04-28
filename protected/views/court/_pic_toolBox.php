<form name="_query_form" id="_query_form" action="javascript:itemQuery(0);">
    <li>
        <span class="sift-title">搜索：</span>
        
        <span style="float:left; margin:0 3px; margin-top:-3px;">图片分类</span>
        <select name="q[type]">
            <option value="">--选择--</option>
            <?php
            $type_list = array(
                    '8'=>'球场标志',
                    '0'=>'球场风景',
                    '1'=>'球道',
                   
                );
            if(@count($type_list) > 0 )
            {
                foreach($type_list as $key=>$value)
                {
                    echo '<option value="'.$key.'">'.$value.'</option>';
                }
            }
            ?>
        </select>
        <input type="hidden" name="q[relation_id]" value="<?php echo $_SESSION['cur_court_id'];?>"/>
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
            <?=$this->picGridId?>.page = arguments[0];
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
<?php echo $this->picGridId; ?>.condition = url;
<?php echo $this->picGridId; ?>.refresh();
    }

</script>