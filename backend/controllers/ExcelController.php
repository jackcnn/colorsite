<?php
/**
 * Date: 2017/9/20 0020
 * Time: 17:06
 * excel导出的测试
 */
namespace backend\controllers;
use backend\controllers\BaseController;
use yii\helpers\UHelper;
class ExcelController extends BaseController
{
    public function actionExcel()
    {
        $db = new \yii\db\Connection([
            'dsn' => 'mysql:host=118.190.74.225;dbname=smgweiyixiao_live',
            'username' => 'smghoutai_live',
            'password' => 'LJYFGHysBOuw',
            'charset' => 'utf8',
            'tablePrefix' => 'pigcms_',
        ]);

        $meta_data = (new \yii\db\Query())
            ->from("{{%preferentialpay_orders}}")
            ->where(['>','pay_time',0])
            ->orderBy("create_time DESC")
            ->select("token,ordersn,openid,pay_amount,wxname")
            ->all($db);

        $data = [];
        foreach($meta_data as $key=>$value){
            $data[$key]['token'] = $value['token'];
            $data[$key]['ordersn'] = $value['ordersn'];
            $data[$key]['openid'] = $value['openid'];
            $data[$key]['pay_amount'] = ($value['pay_amount']/100)."元";
            $data[$key]['wxname'] = urldecode($value['wxname']);
        }

        $title=['token','ordersn','openid','pay_amount','wxname'];
        UHelper::phpexcelSetCache($title,$data,'phpexceltest');
        UHelper::downloadExcel('phpexceltest');
    }


    public function actionDownloadexcel($cacheName)
    {
        UHelper::downloadExcel($cacheName);
    }
}