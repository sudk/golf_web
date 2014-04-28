<?php
/**
 * @author sudk
 */
 
class Command
{
    public $cmdObj=null;
    public $cmd=false;
    public function init(){
        $pd=file_get_contents("php://input");
        Yii::log($pd,'info','application.firebuglog');
        $cmd=json_decode(trim($pd));
        if($cmd){
            $this->cmdObj=$cmd;
            if(isset($cmd->cmd)){
                $this->cmd=$cmd->cmd;
            }
        }
    }
}
