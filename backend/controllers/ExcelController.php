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
            'dsn' => 'mysql:host=localhost;dbname=apivblcc',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ]);

        $data=$db->createCommand("SELECT `openid`,`name`,`tel`,`ctime` FROM doc_hlbm WHERE `name`<>'' and `openid`<>'' and `tel`<>'' ORDER BY `id` DESC")
            ->queryAll();

        $title=['openid字符串','姓名','电话','参与时间'];

        UHelper::phpexcelSetCache($title,$data,'phpexceltest');
        echo "<script>window.open('".\yii\helpers\Url::to(['/index/downloadexcel','cacheName'=>'phpexceltest'])."')</script>";
    }


    public function actionDownloadexcel($cacheName)
    {
        UHelper::downloadExcel($cacheName);
    }
}