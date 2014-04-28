<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AuthBaseController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
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
		}else
        {
            $this->redirect('index.php?r=site/login');
        }

        $this->pageTitle = Yii::app()->name;
	}
	
	/**
	 * Checks if rbac access is granted for the current user
	 * @param String $action . The current action
	 * @return boolean true if access is granted else false
	*/
	protected function beforeAction($action) 
	{
        //return true;
		//rbac access
		$mod = $this->module !== null ? $this->module->id.'/' : "";
		$access =  $mod.$this->id.'/'.$this->action->id;

		//Always allow access if $access is in the allowedAccess array
		if(in_array($access, $this->allowedAccess())) 
		{
			return true;
		}

		//Always allow access if $access is in the allowedAccess array
		if(Yii::app()->user->checkAccess(""))
		{
			return true;
		}

		// Check for rbac access
		if(Yii::app()->user->isGuest)
		{
			$this->renderPartial('//site/login');
		}
		else if(!Yii::app()->user->checkAccess($access)) 
		{
			// You may change this messages
            
			$error["code"] = "403";
			$error["title"] = '';//"您没有权限执行该操作！".($mod==''?'':$mod."/").$this->id."/".$this->action->id."。</div>";
			$error["message"] = "您没有权限执行该操作！" ;
			//You may change the view for unauthorized access
			if(Yii::app()->request->isAjaxRequest) 
			{
				$this->renderPartial('//site/error',array("code"=>$error["code"].' '.$error["title"],"message"=>$error["message"]));
			} else {
				$this->render('//site/error',array("code"=>$error["code"].' '.$error["title"],"message"=>$error["message"]));
			}
			return false;
			}
		else 
		{
            //self::log();
			return true;
		}
	}
	/**
	 * The auth items that access is always  allowed. Configured in rbac module's
	 * configuration
	 * @return The always allowed auth items
	*/
	protected function allowedAccess() {
		return array(
            'dboard/index','site/s','site/index','site/error','site/contact','site/login','site/logout','site/switchwidth','site/updateoperation',
        );
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
        $user_type=1;
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