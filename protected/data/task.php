<?php

return array(
    'user' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '会员管理',
        'children' => array(
             'user/card/grid' ,
            'user/card/list' ,
            'user/card/new' ,
            'user/card/edit' ,
            'user/card/checkid' ,
            'user/card/del' ,
            'user/card/detail' ,
            'user/ucard/grid' ,
            'user/ucard/list' ,
            'user/ucard/new' ,
            'user/ucard/edit' ,
            'user/ucard/editpri' ,
            'user/ucard/checkid' ,
            'user/ucard/checkloginid' ,
            'user/ucard/del' ,
            'user/ucard/detail' ,
            'user/uinfo/grid' ,
            'user/uinfo/list' ,
            'user/uinfo/edit' ,
            'user/uinfo/resetpwd' ,
            'user/uinfo/del' ,
            'user/uinfo/detail' ,
            'user/uscore/grid' ,
            'user/uscore/list' ,
            'user/uscore/detail' ,
        ),
        'bizRules' => '',
        'data' => ''
    ),
    'user_r' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '会员管理-查看',
        'children' => array(
            'user/card/grid' ,
            'user/card/list' ,
           
            'user/card/detail' ,
            'user/ucard/grid' ,
            'user/ucard/list' ,
            'user/ucard/detail' ,
            
            'user/uinfo/grid' ,
            'user/uinfo/list' ,
            'user/uinfo/detail' ,
            
            'user/uscore/grid' ,
            'user/uscore/list' ,
            'user/uscore/detail' ,
        ),
        'bizRules' => '',
        'data' => ''
    ),
    'order' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '订单管理',
        'children' => array(
            'order/grid' ,
            'order/list' ,
            'order/detail' ,
            'order/edit' ,
            'order/lgrid' ,
            'order/log' ,
        ),
        'bizRules' => '',
        'data' => ''
    ),
    'order_r' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '订单管理-查看',
        'children' => array(
            'order/grid' ,
            'order/list' ,
            'order/detail' ,
            'order/lgrid' ,
            'order/log' ,
        ),
        'bizRules' => '',
        'data' => ''
    ),
    'court' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '球场管理',
        'children' => array(
             'court/grid' ,
            'court/list' ,
            'court/new' ,
            'court/edit' ,
            'court/checkid' ,
            'court/getcity' ,
            'court/del' ,
            'court/detail' ,
            'court/showpoint' ,
            'court/showpic' ,
            'court/piclist' ,
            'court/newpic' ,
            'court/loadpic' ,
            'court/delpic' ,
            'court/comment' ,
            'court/commentlist' ,
            'court/mycomment' ,
            
            ),
        'bizRules' => '',
        'data' => ''
    ),
    'court_r' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '球场管理-查看',
        'children' => array(
            'court/grid' ,
            'court/list' ,         
            'court/getcity' ,      
            'court/detail' ,
            'court/showpoint' ,
            'court/showpic' ,
            'court/piclist' ,      
            'court/loadpic' ,   
            'court/comment' ,
            'court/commentlist' ,
            'court/mycomment' ,
            
            ),
        'bizRules' => '',
        'data' => ''
    ),
    'price' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '报价单管理',
        'children' => array(
            	'price/grid' ,
                'price/list' ,
                'price/newpolicy' ,
                'price/edit' ,
                'price/del' ,
                'price/delpolicydetail' ,
                'price/detail' ,
                'price/policygrid' ,
                'price/policy' ,
                'price/customgrid' ,
                'price/custom' ,
                'price/specialgrid' ,
                'price/special' ,
                'price/template' ,
                'price/downtemplate' ,
                'price/loadtemplate' ,
                'price/copypolicy' ,

        ),
        'bizRules' => '',
        'data' => ''
    ),
    'price_r' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>false,
        'description' => '报价单管理-查看',
        'children' => array(
                'price/grid' ,
                'price/list' ,
               
                'price/detail' ,
                'price/policygrid' ,
                'price/policy' ,
                'price/customgrid' ,
                'price/custom' ,
                'price/specialgrid' ,
                'price/special' ,
                
        ),
        'bizRules' => '',
        'data' => ''
    ),
    'service_comp' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '特色服务-赛事管理',
        'children' => array(
            'service/competition/grid' ,
            'service/competition/list' ,
            'service/competition/new' ,
            'service/competition/edit' ,
            'service/competition/checkid' ,
            'service/competition/del' ,
            'service/competition/detail' ,
        ),
        'bizRules' => '',
        'data' => ''
    ),
    'service_goods' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '特色服务-寄卖审核',
        'children' => array(
           
            'service/goods/grid' ,
            'service/goods/list' ,
            'service/goods/audit' ,
            'service/goods/detail' ,
            'service/goods/del' ,
        ),
        'bizRules' => '',
        'data' => ''
    ),
    'service_mcht' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '特色服务-特约商户管理',
        'children' => array(
            
            'service/mcht/grid' ,
            'service/mcht/list' ,
            'service/mcht/new' ,
            'service/mcht/edit' ,
            'service/mcht/checkid' ,
            'service/mcht/del' ,
            'service/mcht/detail' ,
        ),
        'bizRules' => '',
        'data' => ''
    ),
    'service_route' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '特色服务-套餐管理',
        'children' => array(
            'service/route/grid' ,
            'service/route/list' ,
            'service/route/new' ,
            'service/route/edit' ,
            'service/route/del' ,
            'service/route/checkid' ,
            'service/route/detail' ,
        ),
        'bizRules' => '',
        'data' => ''
    ),
    'service_news'=>array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '特色服务-新闻管理',
        'children'=>array(
            'service/news/grid',
            'service/news/list',
            'service/news/new',
            'service/news/edit',
            'service/news/checkid',
            'service/news/del',
            'service/news/detail',
        )
    ),
    'consume_log' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '报表管理-消费记录',
        'children' => array(
           'rpt/consume/grid' ,
            'rpt/consume/list' ,
            'rpt/consume/detail' ,
            'rpt/recharge/grid' ,
            'rpt/recharge/list' ,
        ),
        'bizRules' => '',
        'data' => ''
    ),
    'msg' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>false,
        'description' => '消息管理',
        'children' => array(
            'msg/inbox/grid',
            'msg/inbox/list',
            'msg/outbox/grid',
            'msg/outbox/list',
            'msg/outbox/new',
            'msg/outbox/del',
            'msg/outbox/show',
            'msg/outbox/detail'
        ),
        'bizRules' => '',
        'data' => ''
    ),
    'systemlog' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>false,
        'description' => '系统操作日志',
        'children' => array(
            'log/systemlog/grid','log/systemlog/list','log/systemlog/detail'
        ),
        'bizRules' => '',
        'data' => ''
    ),
    
    'agent' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>true,
        'description' => '代理商管理',
        'children' => array(
           'operator/agent/grid' ,
            'operator/agent/list' ,
            'operator/agent/new' ,
            'operator/agent/edit' ,
            'operator/agent/checkagentname' ,
            'operator/agent/del' ,
        ),
        'bizRules' => '',
        'data' => ''
    ),
    
    'operator' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>false,
        'description' => '操作员管理',
        'children' => array(
            'operator/operator/grid' ,
            'operator/operator/list' ,
            'operator/operator/new' ,
            'operator/operator/edit' ,
            'operator/operator/editpri' ,
            'operator/operator/checkid' ,
            'operator/operator/checkloginid' ,
            'operator/operator/del' ,
            'operator/operator/detail' ,
            'auth/edit' ,
            'auth/delete' ,
        ),
        'bizRules' => '',
        'data' => ''
    ),
    
    'default' => array(
        'type' => CAuthItem::TYPE_TASK,
        'display'=>false,
        'description' => '默认权限',
        'children' => array(
           'dboard/index' ,
           'dboard/system' ,           
            'site/s' ,
            'site/queryarea' ,
            'site/applyquery' ,
            'site/index' ,
            'site/error' ,
            'site/login' ,
            'site/getpass' ,
            'site/logout' ,
            'site/passwd' ,
            'site/updateoperation' ,
            'site/showtask' ,
            'test/index' ,
            'test/cmd' ,
           
        ),
        'bizRules' => '',
        'data' => ''
    ),
    
    
    
);

