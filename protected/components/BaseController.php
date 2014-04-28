<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public static $authInited = false;
    
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

     public function init()
     {
         parent::init();
         if(isset(Yii::app()->user->auths) && count(Yii::app()->user->auths)>0)
         {
             $authManager=Yii::app()->authManager;
             $userId=Yii::app()->user->id;
             foreach(Yii::app()->user->auths as $authid)
             {
                 try{
                     $authManager->assign($authid,$userId);
                 } catch (Exception $e) {
                     continue;
                 }
             }
         }
    }

	public function accessRules()
    {
        return array(
			array('allow',
                'users'=>array('@'),
            ),
			array('deny',
				'actions'=>array(),
			),
        );
    }

    /**
	 * Checks if rbac access is granted for the current user
	 * @param String $action . The current action
	 * @return boolean true if access is granted else false
	*/
	protected function beforeAction($action)
	{
        //self::log();
        return true;
    }

    protected function log($access=""){
        if(Yii::app()->user->isGuest){
            return;
        }
        if($access!=""){
            $operation=$access;
        }else{
            $mod = $this->module !== null ? $this->module->id.'/' : "";
            $operation =  $mod.$this->id.'/'.$this->action->id;
        }
        $unLog=self::unLogAccess();
        if(in_array($operation,$unLog)){
            return;
        }
        $user_id=Yii::app()->user->id;
        $user_name=Yii::app()->user->name;
        $user_type=1;//废除不用
        $ip_add=$_SERVER['REMOTE_ADDR'];

        $request=json_encode($_REQUEST);
        $split="\u01";
        $message=$user_id.$split.$user_name.$split.$user_type.$split.$ip_add.$split.$operation.$split.$request;
        //Yii::app()->redis->getClient()->publish(Yii::app()->params['logChannel'],$message);
    }
    protected function unLogAccess(){
        return array(
            'log/systemlog/list',
            'log/systemlog/grid',
            'log/systemlog/detail'
        );
    }
}