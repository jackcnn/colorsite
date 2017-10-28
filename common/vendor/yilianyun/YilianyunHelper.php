<?php
/**
 * Created by PhpStorm.
 * User: lurongze
 * Date: 2017/10/27
 * Time: 10:36
 */
namespace common\vendor\yilianyun;


//自由模式下的打印机，这些全部都是13828447640账号下的打印机才可以用
class YilianyunHelper
{

    public static function token()
    {
        $cache = \Yii::$app->cache;

        $token = $cache->get('yilianyun_access_token');

        if($token && strlen($token)>10){
            return $token;
        }else{
            require_once ('lib/YLYTokenClient.php');
            $token = new \YLYTokenClient();

            //获取token;
            $grantType = 'client_credentials';  //自有模式(client_credentials) || 开放模式(authorization_code)
            $scope = 'all';                     //权限
            $timesTamp = time();                //当前服务器时间戳(10位)
            //$code = '';                       //开放模式(商户code)
            //{"error":"0","error_description":"success","body":{"access_token":"089db6cac141493282e47ddc93cfb609","refresh_token":"ad4d3b68f7a544e585cd59252525898a","expires_in":2592000,"scope":"all"}}
            $res = $token->GetToken($grantType,$scope,$timesTamp);
            $res = json_decode($res,1);
            if(intval($res['error']) === 0){

                $cache->set('yilianyun_access_token',$res['body']['access_token'],3600*12);

                return $res['body']['access_token'];
            }else{
                return $res;
            }
        }

    }

    //$content 打印内容
    //$machineCode //授权的终端号(测试机的4004543345)
    //$originId  商户自定义id
    public static function printer($content,$machineCode,$originId=0)
    {

        require_once ('lib/YLYOpenApiClient.php');

        $api = new \YLYOpenApiClient();

        $accessToken = self::token();                      //api访问令牌
        $timesTamp = time();                    //当前服务器时间戳(10位)

        if(!$originId){
            $originId = date('YmdHis',time()).mt_rand(111,999);
        }

        $res = $api->printIndex($machineCode,$accessToken,$content,$originId,$timesTamp);

        /*
         * Array
            (
                [error] => 0
                [error_description] => success
                [body] => Array
                    (
                        [id] => 63045641
                        [origin_id] => 20171027105817230
                    )
            )
         * */
        $res = json_decode($res,1);

        if(intval($res['error']) === 0){
            return 'success';
        }else{
            return $res['error_description'];
        }

    }

    //打印机调用demo
    public function demo()
    {

        $content = '';                          //打印内容
        $content .= '<FS><center>8号桌</center></FS>';
        $content .= str_repeat('-',32);
        $content .= '<FS><table>';
        $content .= '<tr><td>商品</td><td>数量</td><td>价格</td></tr>';
        $content .= '<tr><td>土豆回锅肉</td><td>x1</td><td>￥20</td></tr>';
        $content .= '<tr><td>干煸四季豆</td><td>x1</td><td>￥12</td></tr>';
        $content .= '<tr><td>苦瓜炒蛋</td><td>x1</td><td>￥15</td></tr>';
        $content .= '</table></FS>';
        $content .= str_repeat('-',32)."\n";
        $content .= '<FS>金额: 47元</FS>';

        $machineCode = '4004543345';                      //授权的终端号

        $res = \common\vendor\yilianyun\YilianyunHelper::printer($content,$machineCode);

        ColorHelper::dump($res);

    }





}