<?php
namespace frontend\controllers;

use common\models\Category;
use common\models\Gallery;
use common\models\Stores;
use Yii;
use frontend\controllers\BaseController;
use yii\data\Pagination;
class SiteController extends BaseController
{
    public function actionIndex()
    {

        $category = Category::find()->where(['ownerid'=>$this->ownerid])->asArray()->orderBy("sort,id")->all();

        $store = Stores::find()->where(['ownerid'=>$this->ownerid,'id'=>\Yii::$app->request->get("stid")])->asArray()->one();

        return $this->renderPartial("index",[
            'category'=>$category,
            'store'=>$store
        ]);
    }

    public function actionSell()
    {

        return $this->renderPartial("sell");
    }
}
