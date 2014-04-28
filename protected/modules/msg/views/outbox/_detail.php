<table class="formList" width="560">
    <!--
    <thead>
        <tr><th><?php echo $model->title;?></th></tr>
    </thead>
    -->
    <tbody>
    <tr>
        <td><?php echo $model->content;?></td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td>
            <p><span>发布人：<?php echo $model->creator;?></span>   <span>发布时间：<?php echo $model->record_time;?></span></p>
        </td>
    </tr>
    </tfoot>
</table>