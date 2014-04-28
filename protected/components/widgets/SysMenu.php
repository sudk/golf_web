<?php
/**
 * SysMenu class file.
 *
 * @author Wang Dongyang <wangdy@trunkbow.com>
 * @copyright Copyright &copy; 2001-2010 Trunkbow international
 * @modifyer Su DunKuai <sudk@trunkbow.com>
 * @version $Id: SysMenu.php 2597 $
 * @package application.components.widgets
 * @since 1.1.1
 */
class SysMenu extends CWidget
{

    public function Menu()
    {
        $menus = array();
        
        //会员管理
        $sub_menu = array();
        if(Yii::app()->user->checkAccess("user/uinfo/list"))      
            $sub_menu[] = array("title" => "会员信息管理", "url" => "./?r=user/uinfo/list", "match" => array('user\/uinfo\/list','user\/uinfo\/edit','operator\/operator\/detail'));
        if(Yii::app()->user->checkAccess("user/uscore/list"))    
            $sub_menu[] = array("title" => "会员成绩管理", "url" => "./?r=user/uscore/list", "match" => array('user\/uscore\/list','user\/uscore\/detail','user\/uscore\/edit'));    
        //$sub_menu[] = array("title" => "会员卡片管理", "url" => "./?r=user/ucard/list", "match" => 'user\/ucard\/list');
        if(Yii::app()->user->checkAccess("user/card/list"))    
            $sub_menu[] = array("title" => "实体卡片管理", "url" => "./?r=user/card/list", "match" => array('user\/card\/list','user\/card\/edit','user\/card\/new'));
        
        if(count($sub_menu))
        $menus['user'] = array("title" => "会员管理", "url" => "./?r=user/uinfo/list", "child" => $sub_menu);

        //订单管理
        $sub_menu = array();
        if(Yii::app()->user->checkAccess("order/list"))   
            $sub_menu[] = array("title" => "订单管理", "url" => "./?r=order/list", "match" => array('order\/list','order\/log'));
      
        if(count($sub_menu))
        $menus['order'] = array("title" => "订单管理", "url" => "./?r=order/list", "child" => $sub_menu);

        //球场管理
        $sub_menu = array();
        
        $url = "";
        $match = array();
        if(Yii::app()->user->checkAccess("court/list"))
        {
            $url = $url==""?"index.php?r=court/list":$url;
            array_push($match, 'court\/list');
        }
        if(Yii::app()->user->checkAccess("court/new"))
        {
            $url = $url == "" ?  "index.php?r=court/new" : $url;
            array_push($match, 'court\/new');
        }
        
        if(Yii::app()->user->checkAccess("court/showpic"))
        {
            $url = $url == "" ?  "index.php?r=court/showpic" : $url;
            array_push($match, 'court\/showpic');
        }
        if(Yii::app()->user->checkAccess("court/newpic"))
        {
            $url = $url == "" ?  "index.php?r=court/newpic" : $url;
            array_push($match, 'court\/newpic');
        }
        if(Yii::app()->user->checkAccess("court/mycomment"))
        {
            $url = $url == "" ?  "index.php?r=court/mycomment" : $url;
            array_push($match, 'court\/mycomment');
        }
        if(@count($match) >0)
            $sub_menu[] = array("title" => "球场管理", "url" => $url, "match" => $match);
        
        if(Yii::app()->user->checkAccess("court/comment"))
            $sub_menu[] = array("title" => "球场评论管理", "url" => "./?r=court/comment", "match" => array('court\/comment'));
        
        if(count($sub_menu))
        $menus['court'] = array("title" => "球场管理", "url" => ($url==""?'index.php?r=court/comment':$url), "child" => $sub_menu);


        //价格设置
        $sub_menu = array();
        $url = "";
        $match = array();
        if(Yii::app()->user->checkAccess("price/list"))
        {
            $url = $url==""?"index.php?r=price/list":$url;
            array_push($match, 'price\/list');
        }
        if(Yii::app()->user->checkAccess("price/new"))
        {
            $url = $url==""?"index.php?r=price/new":$url;
            array_push($match, 'price\/new');
        }
        if(Yii::app()->user->checkAccess("price/policydetail"))
        {
            $url = $url==""?"index.php?r=price/policydetail":$url;
            array_push($match, 'price\/policydetail');
        }
        if(Yii::app()->user->checkAccess("price/policy"))
        {
            $url = $url==""?"index.php?r=price/policy":$url;
            array_push($match, 'price\/policy');
        }
        if(Yii::app()->user->checkAccess("price/custom"))
        {
            $url = $url==""?"index.php?r=price/custom":$url;
            array_push($match, 'price\/custom');
        }
        if(Yii::app()->user->checkAccess("price/special"))
        {
            $url = $url==""?"index.php?r=price/special":$url;
            array_push($match, 'price\/special');
        }
        if(@count($match) >0)
            $sub_menu[] = array("title" => "报价单管理", "url" => $url, "match" => $match);
       
        if(count($sub_menu))
        $menus['price'] = array("title" => "报价单管理", "url" => $url, "child" => $sub_menu);

        //服务管理
        $sub_menu = array();
        $url = "";
        $match = array();
        if(Yii::app()->user->checkAccess("service/route/list"))
        {
            $url = $url==""?"index.php?r=service/route/list":$url;
            array_push($match, 'service\/route\/list');
        }
        if(Yii::app()->user->checkAccess("service/route/new"))
        {
            $url = $url==""?"index.php?r=service/route/new":$url;
            array_push($match, 'service\/route\/new');
        }
        if(Yii::app()->user->checkAccess("service/route/detail"))
        {
            $url = $url==""?"index.php?r=service/route/detail":$url;
            array_push($match, 'service\/route\/detail');
        }
        if(@count($match))
            $sub_menu[] = array("title" => "套餐", "url" => $url, "match" =>$match);    
        
        $url = "";
        $match = array();
        if(Yii::app()->user->checkAccess("service/goods/list"))
        {
            $url = $url==""?"index.php?r=service/goods/list":$url;
            array_push($match, 'service\/goods\/list');
        }
        if(Yii::app()->user->checkAccess("service/goods/detail"))
        {
            $url = $url==""?"index.php?r=service/goods/detail":$url;
            array_push($match, 'service\/goods\/detail');
        }
        if(@count($match)>0)
            $sub_menu[] = array("title" => "寄卖", "url" => $url, "match" => $match);  
        
        if(Yii::app()->user->checkAccess("service/mcht/list"))
            $sub_menu[] = array("title" => "特约商户管理", "url" => "./?r=service/mcht/list", "match" => array('service\/mcht\/list','service\/mcht\/new','service\/mcht\/detail'));
        //$sub_menu[] = array("title" => "商户评论管理", "url" => "./?r=service/mcht/comment", "match" => array('service\/mcht\/comment'));    
        if(Yii::app()->user->checkAccess("service/adv/list"))
            $sub_menu[] = array("title" => "广告管理", "url" => "./?r=service/adv/list", "match" => array('service\/adv\/list','service\/adv\/new','service\/adv\/detail'));
        if(Yii::app()->user->checkAccess("service/competition/list"))
            $sub_menu[] = array("title" => "赛事管理", "url" => "./?r=service/competition/list", "match" => array('service\/competition\/list','service\/competition\/new','service\/competition\/detail'));
        if(Yii::app()->user->checkAccess("service/news/list"))
            $sub_menu[] = array("title" => "新闻管理", "url" => "./?r=service/news/list", "match" => array('service\/news\/list','service\/news\/new','service\/news\/detail'));
        if(count($sub_menu))
            $menus['service'] = array("title" => "特色服务", "url" => "./?r=service/route/list", "child" => $sub_menu);

        
        //报表管理
        $sub_menu = array();
        if(Yii::app()->user->checkAccess("rpt/consume/list"))
            $sub_menu[] = array("title" => "消费记录", "url" => "./?r=rpt/consume/list", "match" => array('rpt\/consume\/list'));    
        
        if(count($sub_menu))
        $menus['rpt'] = array("title" => "报表管理", "url" => "./?r=rpt/consume/list", "child" => $sub_menu);

        
        $sub_menu = array();
        $url = "";
        if(Yii::app()->user->checkAccess("operator/operator/list"))
        {
            $url = 'index.php?r=operator/operator/list';
            $sub_menu[] = array("title" => "操作员管理", "url" => "./?r=operator/operator/list", "match" => array('operator\/operator\/list','operator\/operator\/new','operator\/operator\/edit'));
        }
        if(Yii::app()->user->checkAccess("log/systemlog/list"))
        {
            $url = "./?r=log/systemlog/list";
            $sub_menu[] = array("title" => "系统操作日志", "url" => "./?r=log/systemlog/list", "match" => 'log\/systemlog\/list');
        }
        //if(Yii::app()->user->checkAccess("operator/set/list"))
            //$sub_menu[] = array("title" => "系统设置", "url" => "./?r=operator/set/list", "match" => array('operator\/set\/list'));
        if(Yii::app()->user->checkAccess("msg/inbox/list")){
            $sub_menu[] = array("title" => "消息管理", "url" => "./?r=msg/inbox/list", "match" => array('msg\/inbox\/list','msg\/news\/list','msg\/outbox\/list','msg\/outbox\/new'));
            $url = "index.php?r=msg/inbox/list";
        }
            
        if(Yii::app()->user->checkAccess("operator/agent/list"))
        {
            $url = "./?r=operator/agent/list";
            $sub_menu[] = array("title" => "代理商管理", "url" => "./?r=operator/agent/list", "match" => array('operator\/agent\/list','operator\/agent\/new'));
        }
        if(count($sub_menu))
        $menus['system'] = array("title" => "系统管理", "url" => $url, "child" => $sub_menu);

        return $menus;
    }

    public function run()
    {
    	return $this->show_system();
    }

    public function show_system() {
        $menus = self::Menu();
        $r = $_REQUEST['r'];
        ?>
    <div id="nav" class="nav">
        <div class="nav-cnt">
            <ul id="main_menu">
                <?php

                $i = 1;

                if(preg_match('/^dboard/',$r)) $class=' class="master current" ';
                else $class = ' class="master" ';
                echo '<li id="m' . $i . '"' . $class . '>';
                echo '<a class="name" href="index.php?r=dboard"><strong>首页</strong></a>';
                echo '<ul class="subnav"><span style="color:#6a8f00; padding-right:0;">常用功能：</span>';
                //if (Yii::app()->user->checkAccess("posrpt/poseff/list"))
                 //   echo '<li><a href="./?r=operator/operator/list" ><span>操作员管理</span></a></li>';
                //if (Yii::app()->user->checkAccess("posrpt/posdetail/list"))
                    echo '<li><a href="./?r=log/systemlog/list" ><span>系统日志</span></a></li>';
                echo "</ul></li>";
                self::showMenu($menus,$r,++$i);
                ?>
            </ul>
        </div>
    </div>
    <?php
    }


    public function showMenu($menus,$r,$i) {
        $html_str="";
        if(count($menus)>0) {
            foreach ($menus as $id => $menu) {
                $class=' class="master" ';
                $current_sub=false;
                $sub_html_str="";
                if (count($menu['child']) > 0) {
                    $sub_html_str= '<ul class="subnav">';
                    foreach ($menu['child'] as $sub_menu) {
                        if($sub_menu['match']!='' && self::menuMatch($sub_menu['match'],$r)) {
                            $sub_class=' class="current" ';
                            $current_sub=true;
                        }
                        else {
                            $sub_class = '';
                        }
                        if($sub_menu['title'] != '')
                            $sub_html_str.= '<li '.$sub_class.'><a href="' . $sub_menu['url'] . '"><span>' . $sub_menu['title'] . '</span></a></li>';
                    }
                    //$sub_html_str=substr_replace($sub_html_str,"",-33,28);
                    $sub_html_str.= '</ul>';
                }
                if($current_sub) {
                    $class=' class="master current" ';
                }
                $main_html_class= '<li id="m' . $i .'"'.$class.'><a class="name" href="'.$menu['child'][0]['url'].'"><strong>' . $menu['title'] . '</strong></a>';

                $sub_html_str=$main_html_class.$sub_html_str."</li>";

                $html_str.=$sub_html_str;
                $i++;
            }
        }
        //$html_str=substr_replace($html_str,"",-33,28);
        echo $html_str;
    }

    public function menuMatch($match,$r) {
        if(!$match) {
            return false;
        }
        if(is_array($match)) {
            foreach($match as $v) {
                if(preg_match('/\b'.$v.'\b/',$r)) {
                    return true;
                }
            }
        }else {
            return preg_match('/\b'.$match.'\b/',$r);
        }
    }
}
