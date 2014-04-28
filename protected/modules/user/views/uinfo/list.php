<div class="title-box">
    <h1><span style="float:left;">会员列表</span></h1>
    <ul class="sift">
        <?php $this->renderPartial('_toolBox'); ?>
    </ul>
</div>
<div id="datagrid">
    <?php $this->actionGrid(); ?>
</div>
<style type="text/css">
    #row_desc span{
        color: #808080;
    }
</style>
<script type="text/javascript">
    var itemEdit = function (id) {
        tipsWindown(
            "编辑会员信息", // title：窗口标题
            "iframe:index.php?r=user/uinfo/edit&id=" + id, // Url：弹窗所加截的页面路径
            "900", // width：窗体宽度
            "520", // height：窗体高度
            "true", // drag：是否可以拖动（ture为是,false为否）
            "", // time：自动关闭等待的时间，为空代表不会自动关闭
            "true", // showbg：设置是否显示遮罩层（false为不显示,true为显示）
            "text"    // cssName：附加class名称
        );
    }
    
    var itemDelete = function(id,name){
        if(!confirm("确认要删除:"+name+"吗？")){return ;}
        $.ajax({
            data:{id:id},
            url:"index.php?r=user/uinfo/del",
            dataType:"json",
            type:"POST",
            success:function(data){
                if(data.status){
                    alert("删除成功！");
                    itemQuery();
                }else{
                    alert("删除失败！");
                }
            }
        })
    }
    
    var itemResetPwd = function(id,name){
        if(!confirm("确认要重置会员:"+name+"的密码吗？")){return ;}
        $.ajax({
            data:{id:id},
            url:"index.php?r=user/uinfo/resetpwd",
            dataType:"json",
            type:"POST",
            success:function(data){
                if(data.status){
                    alert("重置成功！默认密码重置为666666.");
                    itemQuery();
                }else{
                    alert("重置失败！");
                }
            }
        })
    }

    var showDetail = function (obj, desc, show) {
        $("#row_desc").remove();
        if (c_Note) {
            $(c_Note).removeClass("towfocus");
        }
        if (show && c_Note == obj) {
            c_Note = null;
            return;
        }
        $(obj).after("<tr id='row_desc' class='towfocus' ><td colspan='"+obj.cells.length+"'>" + desc + "</td></tr>");
        c_Note = obj;
        $(c_Note).addClass("towfocus");
    }
    var c_Note=null;
    var datainfo={};
    var getDetail=function(obj,objid){
        if(datainfo[objid]){
            showDetail(obj,datainfo[objid],true);
            return;
        }
        var detail="";
        $.ajax({
            data:{id:objid},
            url:"./?r=user/uinfo/detail",
            type:"POST",
            dataType:"json",
            beforeSend:function(){
                detail="正在获取数据...";
                showDetail(obj,detail,false);
            },
            success:function(data){
                detail=data.detail
                if(data.status){
                    datainfo[objid]=detail;
                }
                showDetail(obj,detail,false);
            }
        })
    }
</script>