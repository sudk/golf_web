<form id="form1" action="javascript:cmd();">
    <table>
        <tr>
            <td>
                <textarea id="text" name="text"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="执行">
            </td>
        </tr>
        <tr>
            <td id="result"></td>
        </tr>
    </table>
</form>
<script>
    var cmd=function(){
        $.ajax({
            url:"./?r=test/cmd",
            data:{content:$("#text").val()},
            type:'POST',
            beforeSend:function(jqXHR,settings){
                $("#result").html("start to run cmd");
            },
            success:function(data,textStatus){
                $("#result").html(data);
            }
        })
    }
</script>