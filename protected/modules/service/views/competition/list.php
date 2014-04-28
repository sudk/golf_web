<div id="content">
    <div class="title-box">
        <h1>赛事管理<a href="./?r=service/competition/new" style="float:right;"><span class="add_ico"></span><span>赛事添加</span></a>
        </h1>
        <ul class="sift">
            <?php $this->renderPartial('_toolBox'); ?>
        </ul>
    </div>

    <div id="datagrid">
        <?php $this->actionGrid(); ?>
    </div>
</div>
    <script type="text/javascript">
        
        var itemEdit = function (id) {
        tipsWindown(
            "编辑赛事信息", // title：窗口标题
            "iframe:index.php?r=service/competition/edit&id=" + id, // Url：弹窗所加截的页面路径
            "900", // width：窗体宽度
            "520", // height：窗体高度
            "true", // drag：是否可以拖动（ture为是,false为否）
            "", // time：自动关闭等待的时间，为空代表不会自动关闭
            "true", // showbg：设置是否显示遮罩层（false为不显示,true为显示）
            "text"    // cssName：附加class名称
        );
    }
    
    var itemDetail=function(id){
        window.location.href = 'index.php?r=service/competition/detail&id='+id;
    }
    
    
   
    var itemDelete = function(id,name){
        if(!confirm("确认要删除赛事:"+name+"吗？")){return ;}
        $.ajax({
            data:{id:id},
            url:"index.php?r=service/competition/del",
            dataType:"json",
            type:"POST",
            success:function(data){
                if(data.status){
                    alert("删除成功！");
                    itemQuery();
                }else{
                    alert(data.msg);
                }
            }
        })
    }
    </script>