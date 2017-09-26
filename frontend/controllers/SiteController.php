<?php
namespace frontend\controllers;

use common\models\Gallery;
use Yii;
use frontend\controllers\BaseController;
use yii\data\Pagination;
class SiteController extends BaseController
{
    public $layout = "gallerys";
    public function actionIndex($token)
    {
        $query = Gallery::find()->where(['isopen'=>1,'token'=>$token]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count,'defaultPageSize'=>1]);
        $gallerys = $query->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        return $this->render('index',['gallerys'=>$gallerys,'pagination'=>$pagination]);
    }

    public function actionImg()
    {
        $url = "http://colorsite.com/uploads/00039/201709/3a05fbf77ed92e244cdbaa6c52cd746b.jpg";
        $content = file_get_contents($url);
        echo "data:image/jpg;base64,".base64_encode($content);
    }
}
