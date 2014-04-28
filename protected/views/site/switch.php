<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangdy
 * Date: 12-1-24
 * Time: 下午4:57
 * To change this template use File | Settings | File Templates.
 */

/**
 * 查询校管理员管理的学校
 */
$rows = Yii::app()->db->createCommand()
    ->select('o.schoolid,s.name')
    ->from('opschool o')
    ->join('school s', 'o.schoolid=s.schoolid')
    ->where('o.operatorid=:operatorid and s.status=0', array(':operatorid'=>Yii::app()->user->id))
    ->queryAll();

if(count($rows)==1)
{
?>

当前只管理一所学校，不能切换。

<?php
}
else
{
    foreach($rows as $row)
    {
        echo '<li><p><a href="index.php?r=site/switchschool&id='.$row['schoolid'].'">'.$row['name'].'</a></p></li>';
    }
?>

<?php
}
?>