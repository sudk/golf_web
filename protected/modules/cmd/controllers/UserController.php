<?php

/**
 * 用户接口
 * @author sudk
 */
class UserController extends CMDBaseController
{
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('info','Bandcard'),
                'users' => array('@'),
            ),
            array('allow',
                'users' => array('*'),
            ),
            array('deny',
                'actions' => array(),
            ),
        );
    }

    public function actionLogin()
    {

        if (!Yii::app()->command->cmdObj->phone) {
            $msg['desc']="缺少参数";
            $msg['status']=-1;
            echo json_encode($msg);
            return;
        }

        if (!Yii::app()->command->cmdObj->passwd) {
            $msg['desc']="缺少参数";
            $msg['status']=-1;
            echo json_encode($msg);
            return;
        }

        $identity = new MUserIdentity(trim(Yii::app()->command->cmdObj->phone), trim(Yii::app()->command->cmdObj->passwd));
        $identity->authenticate();
        switch ($identity->errorCode) {
            case UserIdentity::ERROR_NONE:
                $duration = isset($form['rememberMe']) ? 3600 * 24 * 1 : 0; // 1 day
                Yii::app()->user->login($identity);
                //echo Yii::app()->user->id;
                if ($duration !== 0) {
                    setcookie('golf', trim($form['username']), time() + $duration, Yii::app()->request->baseUrl);
                } else {
                    unset($_COOKIE['golf']);
                    setcookie('golf', NULL, -1);
                }
                $message = '成功！';
                $status=0;
                $msg['data']=User::FindOneByPhone(Yii::app()->user->id);
                break;
            case UserIdentity::ERROR_USERNAME_INVALID:
                $message = '用户名错误！';
                $status=1;
                break;
            case UserIdentity::ERROR_PASSWORD_INVALID:
                $message = '密码错误！';
                $status=2;
                break;
            default:
                $message = '用户名或口令错误！';
                $status=3;
                break;
        }
        $msg['desc']=$message;
        $msg['status']=$status;
        echo json_encode($msg);

    }

    public function actionRegiste(){
        $model=new User('create');
        $model->phone=Yii::app()->command->cmdObj->phone;
        $model->user_name=Yii::app()->command->cmdObj->user_name;
        $model->card_no=Yii::app()->command->cmdObj->card_no;
        $model->email=Yii::app()->command->cmdObj->email;
        $model->sex=Yii::app()->command->cmdObj->sex;
        $model->record_time=date("Y-m-d H:i:s");
        $model->passwd=crypt(trim(Yii::app()->command->cmdObj->passwd));
        if($model->validate()){
            try{
                $model->save();
                $msg['status']=0;
                $msg['desc']="成功";
                $msg['data']=User::FindOneByPhone(Yii::app()->command->cmdObj->phone);
            }catch (Exception $e){
                $msg['status']=$e->getCode();
                if($e->getCode()==23000){
                    $msg['desc']='账号已经存在！';
                }else{
                    $msg['desc']=$e->getMessage();
                }
            }
        }else{
            $msg['status']=1;
            $msg['desc']="缺少参数";
        }
        echo json_encode($msg);
    }

    public function actionLogout(){
        Yii::app()->user->logout();
        $msg['status']=0;
        $msg['desc']="成功";
        echo json_encode($msg);
    }

    public function actionInfo(){
        //echo Yii::app()->user->id;
        if(!Yii::app()->user->isGuest){
            //User::model()->find("phone=:phone",array(':phone'=>Yii::app()->user->id));
            $user=User::FindOneByPhone(Yii::app()->user->id);
            if($user){
                $msg['status']=0;
                $msg['desc']="成功";
                $msg['data']=$user;
            }else{
                $msg['status']=5;
                $msg['desc']="获取用户信息失败";
            }
        }else{
            $msg['status']=4;
            $msg['desc']="未登陆";
        }
        echo json_encode($msg);
    }

    public function actionBandcard(){
        if(!Yii::app()->user->isGuest){
            if(!Yii::app()->command->cmdObj->card_no){
                $msg['status']=7;
                $msg['desc']="卡号不能为空";
                echo json_encode($msg);
                return;
            }
            $model=User::model()->find("phone=:phone",array(":phone"=>Yii::app()->user->id));
            if($model){
                $model->card_no=Yii::app()->command->cmdObj->card_no;
                $rs=$model->save();
                if($rs){
                    $msg['status']=0;
                    $msg['desc']="成功";
                }else{
                    $msg['status']=6;
                    $msg['desc']="保存卡片信息失败";
                }
            }else{
                $msg['status']=5;
                $msg['desc']="获取用户信息失败";
            }
        }else{
            $msg['status']=4;
            $msg['desc']="未登陆";
        }
        echo json_encode($msg);
    }

    public function actionSmstoken(){
        if(!Yii::app()->command->cmdObj->phone){
            $msg['status']=8;
            $msg['desc']="手机号不能为空";
            echo json_encode($msg);
            return;
        }
        $model=User::model()->find("phone=:phone",array(":phone"=>Yii::app()->command->cmdObj->phone));
        if($model){
            Yii::app()->fcache->set(Yii::app()->command->cmdObj->phone,1111,60*5);
            $msg['status']=0;
            $msg['desc']="成功";
        }else{
            $msg['status']=9;
            $msg['desc']="手机号不存在";
        }
        echo json_encode($msg);
    }

    public function actionChangepwd(){
        if(!Yii::app()->command->cmdObj->phone){
            $msg['status']=8;
            $msg['desc']="手机号不能为空";
            echo json_encode($msg);
            return;
        }
        $model=User::model()->find("phone=:phone",array(":phone"=>Yii::app()->command->cmdObj->phone));
        if($model){
            $token=Yii::app()->fcache->get(Yii::app()->command->cmdObj->phone);
            if($token&&$token==Yii::app()->command->cmdObj->smstoken){
                $model->passwd=crypt(Yii::app()->command->cmdObj->passwd);
                $msg['status']=0;
                $msg['desc']="成功";
            }else{
                $msg['status']=10;
                $msg['desc']="验证码错误";
            }
        }else{
            $msg['status']=9;
            $msg['desc']="手机号不存在";
        }
        echo json_encode($msg);
    }

    public function actionSecurity()
    {
        //echo session_id();
        echo "-----";
        //Yii::app()->fcache->set(session_id(),);

    }
}