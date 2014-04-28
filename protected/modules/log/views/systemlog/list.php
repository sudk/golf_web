<div id="content">
    <div class="title-box">
        <h1>系统操作日志
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
        var tostr=function(obj){
            var json_str="";
            if(typeof obj=="object"){
                for(k in obj)
                {
                    if(typeof obj[k] =="object"){
                        var str=tostr(obj[k]);
                    }else{
                        var str=k+"="+obj[k]+"<br>";
                    }
                    json_str+=str;
                }
                return  json_str;
            }else {
                return  obj;
            }
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
            desc=tostr(desc);
            $(obj).after("<tr id='row_desc'  class='towfocus' ><td width='700px' colspan='6'><p>" + desc + "</p></td></tr>");
            c_Note = obj;
            $(c_Note).addClass("towfocus");
        }
        var c_Note=null;
        var datainfo={};
        var getDetail=function(obj,objid,objtime){
            if(datainfo[objid]){
                showDetail(obj,datainfo[objid],true);
                return;
            }
            var detail="";
            $.ajax({
                data:{id:objid,recordtime:objtime},
                url:"index.php?r=log/systemlog/detail",
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