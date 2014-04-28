<?php
/*
 * 模块编号: M1001
 */
class TestController extends BaseController
{
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','cmd'),
                'users' => array('*'),
            ),
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'actions' => array(),
            ),
        );
    }

    public function actionIndex(){
        $this->render("index");

    }

    public function actionCmd(){
        if($_POST['content']){
//            $rq_h=getallheaders();
//            if($rq_h['Cookie']){
//                $cookie="Cookie: {$rq_h['Cookie']}";
//            }
//            echo $cookie;
            $tuCurl = curl_init();
            $url="http://localhost/golf/web/index.php?r=command";
            curl_setopt($tuCurl, CURLOPT_URL,$url);
            //curl_setopt($tuCurl, CURLOPT_VERBOSE, 0);
            curl_setopt($tuCurl, CURLOPT_TIMEOUT,5);
            curl_setopt($tuCurl, CURLOPT_HEADER,true);
            curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($tuCurl, CURLOPT_POST,true);
            curl_setopt($tuCurl, CURLOPT_POSTFIELDS,$_POST['content']);
            //curl_setopt($tuCurl, CURLOPT_HTTPHEADER,array("Cookie: n8lca91gg1gdtk0n000uhkaq97"));
            curl_setopt($tuCurl, CURLOPT_COOKIEFILE, '/Applications/XAMPP/htdocs/golf/web/assets/cookie.txt');
            curl_setopt($tuCurl, CURLOPT_COOKIEJAR, '/Applications/XAMPP/htdocs/golf/web/assets/cookie.txt');
            $rs=curl_exec($tuCurl);
            list($header, $data) = explode("\n\n",$rs,2);
            curl_close($tuCurl);
            var_dump($header);
            var_dump($data);
        }
    }

}