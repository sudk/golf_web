<div id="content">
    <div class="tab">
        <ul class="tab-label">
            <li class="current"><a>收件箱</a></li>
            <li><a href="./?r=msg/outbox/list">发件箱</a></li>
            <li><a href="./?r=msg/outbox/new">新建消息</a></li>
        </ul>
        <ul class="sift">
            <?php $this->renderPartial('_toolBox'); ?>
        </ul>
    </div>
    <div id="datagrid">
        <?php $this->actionGrid(); ?>
    </div>
</div>
    <script type="text/javascript">
        var itemDetail = function (id) {
            tipsWindown(
                "消息详细", // title：窗口标题
                "iframe:index.php?r=msg/outbox/show&id=" + id, // Url：弹窗所加截的页面路径
                "700", // width：窗体宽度
                "420", // height：窗体高度
                "true", // drag：是否可以拖动（ture为是,false为否）
                "", // time：自动关闭等待的时间，为空代表不会自动关闭
                "true", // showbg：设置是否显示遮罩层（false为不显示,true为显示）
                "text"    // cssName：附加class名称
            );
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
        var mchtinfo={};
        var getDetail=function(obj,id){
            if(mchtinfo[id]){
                showDetail(obj,mchtinfo[id],true);
                return;
            }
            var detail="";
            $.ajax({
                data:{id:id},
                url:"index.php?r=msg/outbox/detail",
                type:"POST",
                dataType:"json",
                beforeSend:function(){
                    detail="正在获取数据...";
                    showDetail(obj,detail,false);
                },
                success:function(data){
                    detail=data.detail
                    if(data.status){
                        mchtinfo[id]=detail;
                    }
                    showDetail(obj,detail,false);
                }
            })
        }
    </script>