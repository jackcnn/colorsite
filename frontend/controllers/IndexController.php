<?php
namespace frontend\controllers;

use Yii;
use frontend\controllers\BaseController;
use yii\data\Pagination;
use yii\helpers\ColorHelper;
use yii\helpers\CurlHelper;
use yii\helpers\Url;

class IndexController extends BaseController
{

    public $enableCsrfValidation = false;
    public $layout = "index";

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionYilianyun()
    {
        //uid:14400
        //apikey:e7d3a54d369b46e56c2ea3179a8e1bc37392db91
        echo '{"data":"OK"}';
    }

    public function actionYily()
    {
        $content = '';                          //打印内容
        $content .= '<FS><center>8号桌</center></FS>';
        $content .= str_repeat('-',32);
        $content .= '<FS><table>';
        $content .= '<tr><td>商品</td><td>数量</td><td>价格</td></tr>';
        $content .= '<tr><td>土豆回锅肉</td><td>x1</td><td>￥20</td></tr>';
        $content .= '<tr><td>不要辣，不要甜，不要其他的东西，不要其他的东西，不要其他的东西，不要其他的东西</td><td></td><td></td></tr>';
        $content .= '<tr><td>干煸四季豆</td><td>x1</td><td>￥12</td></tr>';
        $content .= '<tr><td>苦瓜炒蛋</td><td>x1</td><td>￥15</td></tr>';
        $content .= '</table></FS>';
        $content .= str_repeat('-',32)."\n";
        $content .= '<FS>金额: 47元</FS>';

        $machineCode = '4004543345';                      //授权的终端号

        $res = \common\vendor\yilianyun\YilianyunHelper::printer($content,$machineCode);

        ColorHelper::dump($res);
    }

    public function actionQr()
    {

        $str = "https://326108993.com/site/index.html?store_id=1&token=bRGqRLRqA&sn=".ColorHelper::orderSN(2);

        $content = "";

        $content .= "<FS><center>微信扫码点餐</center></FS>";
        $content .= str_repeat('-',32);
        $content .= "1.和好友一起扫码共同点餐\r\n";
        $content .= "2.大家都点好后提交即可呼叫服务员确认下单\r\n";
        $content .= "3.用餐结束呼叫服务员买单\r\n";
        $content .= "4.服务员确认买单\r\n";
        $content .= "5.重新扫码即可微信支付订单，最后完成\r\n";
        $content .= "<center><QR>".$str."</QR></center>";
        $machineCode = '4004543345';                      //授权的终端号
        $res = \common\vendor\yilianyun\YilianyunHelper::printer($content,$machineCode);
        if($res == 'success'){
            echo '打印成功！';
        }else{
            echo '打印失败！';
        }

    }






}