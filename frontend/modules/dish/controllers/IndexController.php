<?php
/**
 * Date: 2017/10/17 0017
 * Time: 19:14
 */


namespace frontend\modules\dish\controllers;

use common\models\Category;
use common\models\Clerk;
use common\models\Dishcart;
use common\models\Dishes;
use common\models\Dishorder;
use common\models\Gallery;
use common\models\Stores;
use Yii;
use frontend\controllers\BaseController;
use yii\data\Pagination;
use yii\helpers\ColorHelper;
use yii\helpers\Url;

class IndexController extends BaseController
{

    public function actionIndex($store_id)
    {
        ColorHelper::wxlogin($this->ownerid);



        $store = Stores::findOne($store_id);
        return $this->renderPartial("index",[
            'store'=>$store
        ]);
    }

    //操作结果提示页面
    public function actionRes()
    {

    }



}