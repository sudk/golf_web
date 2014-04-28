<div id="content">
    <div class="tab">
        <ul class="tab-label" style="width:100%" >
            <li><a  href="./?r=msg/inbox/list">收件箱</a></li>
            <li><a href="./?r=msg/outbox/list">发件箱</a></li>
            <li class="current"><a href="./?r=msg/outbox/new">新建消息</a></li>
        </ul>
        <ul class="sift">
            <?php $this->renderPartial('_form',array('model' => $model, 'msg' => $msg,'op_ar'=>$op_ar));?>
        </ul>
    </div>
</div>