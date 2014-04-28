<div class="title-box">
    <h1><span style="float:left;">球场评论</h1>
    <ul class="sift">
        <?php $this->renderPartial('_comment_toolBox'); ?>
    </ul>
</div>
<div id="datagrid">
    <?php $this->actionCommentList(); ?>
</div>
<style type="text/css">
    #row_desc span{
        color: #808080;
    }
</style>
<script type="text/javascript">
    
   
    var itemDelete = function(id){
        if(!confirm("确认要删除评论吗？")){return ;}
        $.ajax({
            data:{id:id},
            url:"index.php?r=court/delcomment",
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