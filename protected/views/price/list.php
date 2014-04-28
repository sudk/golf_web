<div class="title-box">
    <h1><span style="float:left;">报价单管理</span>
        <a href="javascript:void(0);" onclick="javascript:copyPolicy();" style="float:right;margin-left: 15px;"><span class="mover_ico"></span><span>一键复制上月报价</span></a>
        <a href="javascript:void(0);" onclick="javascript:loadTemplate('2');"  style="float:right;margin-left: 15px;"><span class="add_ico"></span><span>特殊报价批量导入</span></a>
        <a href="javascript:void(0);" onclick="javascript:loadTemplate('0');"  style="float:right;margin-left: 15px;"><span class="add_ico"></span><span>普通报价批量导入</span></a>
        <a href="javascript:void(0);" onclick="javascript:downTemplate();"  style="float:right;margin-left: 15px;"><span class="file_ico"></span><span>报价模板下载</span></a>
        
    </h1>
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
    function downTemplate(){
        tipsWindown(
            "下载报价单模板", // title：窗口标题
            "iframe:index.php?r=price/template", // Url：弹窗所加截的页面路径
            "700", // width：窗体宽度
            "520", // height：窗体高度
            "true", // drag：是否可以拖动（ture为是,false为否）
            "", // time：自动关闭等待的时间，为空代表不会自动关闭
            "true", // showbg：设置是否显示遮罩层（false为不显示,true为显示）
            "text"    // cssName：附加class名称
        );
    }
    
    function loadTemplate(tag){
        tipsWindown(
            "编辑报价单信息", // title：窗口标题
            "iframe:index.php?r=price/loadtemplate&tag="+tag, // Url：弹窗所加截的页面路径
            "700", // width：窗体宽度
            "520", // height：窗体高度
            "true", // drag：是否可以拖动（ture为是,false为否）
            "", // time：自动关闭等待的时间，为空代表不会自动关闭
            "true", // showbg：设置是否显示遮罩层（false为不显示,true为显示）
            "text"    // cssName：附加class名称
        );
    }
    
    function copyPolicy(){
        if(!confirm("确认要复制上个月的报价单吗？本月已有报价不会被覆盖，上月无报价不复制")){return ;}
        $.ajax({
            //data:{},
            url:"index.php?r=price/copypolicy",
            dataType:"json",
            type:"POST",
            success:function(data){
                if(data.status==1){
                    alert("复制成功！");
                    itemQuery();
                }else{
                    alert(data.msg);
                }
            }
        })
    }
    
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
    //普通报价
    var itemDetail=function(id,month){
        window.location.href = 'index.php?r=price/policy&id='+id+'&month='+month;
    }
    //优惠报价
    var itemFoverDetail = function(id,month)
    {
        window.location.href = 'index.php?r=price/custom&id='+id+'&month='+month;
    }
    //特殊报价
    var itemCustomDetail = function(id,month)
    {
        window.location.href = 'index.php?r=price/special&id='+id+'&month='+month;
    }
   
    var itemDelete = function(id,name){
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
            url:"./?r=price/detail",
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