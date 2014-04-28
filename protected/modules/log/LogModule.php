<?php

/**
 * ProjectModule is the module that Pm in the application
 * author:sudk
 */
class LogModule extends CWebModule {

    public $pageSite;
	
    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components       
		 
    $this->setImport(array(
        'log.models.*',
		'log.components.*',
		'log.components.widgets.*',
    ));
    // import the module-level models and components
   
	
    }

    public function beforeControllerAction($controller, $action) {
        if(parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
}