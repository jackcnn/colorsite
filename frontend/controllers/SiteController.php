<?php
namespace frontend\controllers;

use common\models\Category;
use common\models\Dishes;
use common\models\Gallery;
use common\models\Stores;
use Yii;
use frontend\controllers\BaseController;
use yii\data\Pagination;
use yii\helpers\ColorHelper;

class SiteController extends BaseController
{
    public function actionIndex()
    {

        $store = Stores::find()->where(['ownerid'=>$this->ownerid,'id'=>\Yii::$app->request->get("stid")])->asArray()->one();

        $category = Category::find()->where(['ownerid'=>$this->ownerid,'table'=>'restaurant'])->asArray()->orderBy("sort,id")->all();

        $dishes = Dishes::find()->where(['ownerid'=>$this->ownerid])->asArray()->orderBy("sort,id")->all();

        $alldishes = $dishes;

        foreach($category as $key=>$value){

            foreach($dishes as $k=>$v){

                if($v['cateid'] == $value['id']){

                    $category[$key]['dishes'][] = $v;

                    unset($dishes[$k]);
                }

            }

        }

        return $this->renderPartial("index",[
            'category'=>$category,
            'store'=>$store,
            'dishes'=>$alldishes
        ]);
    }

    public function actionSell()
    {

        return $this->renderPartial("sell");
    }
}
