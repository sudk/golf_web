<script type="text/javascript">
    jQuery(document).ready(function (){
        $("#btnDownload").hide();
        $("#btnDownload_right").hide();
        jQuery("#btnSubmit").click(function () {
            var taskid = document.forms[0].taskid.value;
            var getTask=function() {
                $.ajax({
                    url:'./?r=rpt/schooldetail/getstatus&taskid=' + taskid,
                    dataType:'json',
                    success:function (m) {
                        var data = m;
                        $('#r_status').html(data.desc);
                        $("#btnSubmit").hide();
                        $("#btnSubmit_right").hide();
                        if(data.status == 4){
                            $("#btnDownload").attr("href",data.downurl)
                            $("#btnDownload").show();
                            $("#btnDownload_right").show();
                        }else{
                            setTimeout(getTask, 1000)
                        }
                    }
                })
            }
            getTask();
        });
    });

</script>
<?php
$form = $this->beginWidget('SimpleForm', array(
    'id' => 'form1',
    'enableAjaxSubmit' => false,
    'ajaxUpdateId' => 'form-container',
    'focus' => array($model, name),
    'htmlOptions' => array("enctype" => "multipart/form-data"),
));
?>
<table class="formList">
    <tr>
        <td colspan="2"><label>您将导出【<?php echo $sqldesc;?>】的报表</label></td>
    </tr>
    <tr>
        <td colspan="2"><label id="r_status"></label></td>
    </tr>
    <tr class="btnBox">
        <td colspan="2">
            <span class="sBtn">
                <a id="btnSubmit" class="left">生成报表</a><a id="btnSubmit_right" class="right"></a>
                <a id="btnDownload" class="left">点击下载</a><a id="btnDownload_right" class="right"></a>
            </span>
        </td>
    </tr>
    <input name="taskid" type="hidden" value=<?php echo $taskid;?>>
</table>
<?php $this->endWidget(); ?>
