<div class="title-box">
    <h1><span style="float:left;">优惠价格设置</span><a href="./?r=price/list" style="float:right;"><span class="ing_ico"></span><span>返回报价单列表</span></a><?php if($month == ""){?><a href="javascript:void(0);" onclick="javascript:itemNew('<?php echo $relation_id;?>','1');" style="float:right;"><span class="add_ico"></span><span>报价单添加</span></a><?php } ?></h1>
    <ul class="sift">
        <?php //$this->renderPartial('_pic_toolBox'); ?>
    </ul>
</div>
<div id="datagrid">
    <?php $this->actionCustomGrid($relation_id,$month); ?>
</div>
<style type="text/css">
    #row_desc span{
        color: #808080;
    }
</style>
<script type="text/javascript">
    //为一个球场提交报价
    var itemNew = function (id,tag) {
        tipsWindown(
            "编辑报价单信息", // title：窗口标题
            "iframe:index.php?r=price/newPolicy&id=" + id+'&tag='+tag, // Url：弹窗所加截的页面路径
            "900", // width：窗体宽度
            "720", // height：窗体高度
            "true", // drag：是否可以拖动（ture为是,false为否）
            "", // time：自动关闭等待的时间，为空代表不会自动关闭
            "true", // showbg：设置是否显示遮罩层（false为不显示,true为显示）
            "text"    // cssName：附加class名称
        );
    }
    var itemEdit = function (id,tag) {
        tipsWindown(
            "编辑报价单信息", // title：窗口标题
            "iframe:index.php?r=price/edit&id=" + id+'&tag='+tag, // Url：弹窗所加截的页面路径
            "900", // width：窗体宽度
            "520", // height：窗体高度
            "true", // drag：是否可以拖动（ture为是,false为否）
            "", // time：自动关闭等待的时间，为空代表不会自动关闭
            "true", // showbg：设置是否显示遮罩层（false为不显示,true为显示）
            "text"    // cssName：附加class名称
        );
    }
   
    var itemDelete = function(id){
        if(!confirm("确认要删除报价单吗？")){return ;}
        $.ajax({
            data:{id:id},
            url:"index.php?r=price/del",
            dataType:"json",
            type:"POST",
            success:function(data){
                if(data.status){
                    alert("删除成功！");
                    itemQuery();
                }else{
                    alert("删除失败！"+data.msg);
                }
            }
        })
    }

</script>