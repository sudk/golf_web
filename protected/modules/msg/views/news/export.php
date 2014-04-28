<head>
    <script type="text/javascript">
    </script>
</head>
<body>
<?php
if ($result['message'] != '') {
    echo '<div class="success">' . $result['message'] . '</div>';
}
else if ($result['error'] != '') {
    echo '<div class="error">' . $result['error'] . '</div>';
}
?>
<div id="form-container">
    <?php $this->renderPartial('_export', array('model' => $model, '_mode_' => 'export','taskid' => $taskid ,'sqldesc' => $sqldesc)); ?>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("body").css('background-image', 'url()');
    });
</script>
</body>