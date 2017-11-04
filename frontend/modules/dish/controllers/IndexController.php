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
    public $enableCsrfValidation = false;
    //门店列表，暂时不弄
    public function actionIndex($sid,$tid)
    {
        echo 1231;die;
    }
    //扫码进入点餐列表
    public function actionGetdishes($sid,$tid)
    {
        $store = Stores::find()->where(['id'=>$sid])->asArray()->one();

        $category = Category::find()->where(['table'=>'restaurant'])->asArray()->orderBy("sort,id")->all();

        $dishes = Dishes::find()->where(['ownerid'=>$store['ownerid']])->asArray()->orderBy("sort,id")->all();

        $alldishes = $dishes;

        foreach($category as $key=>$value){

            foreach($dishes as $k=>$v){

                if($v['cateid'] == $value['id']){
                    if($v['labes']){
                        $labels = explode(",",$v['labes']);
                        $res = [];
                        foreach($labels as $lk=>$lv){
                            $res[$lk]['name'] = $lv;
                            $res[$lk]['sel'] = 0;
                        }

                        $v['label_list'] = $res;
                    }else{
                        $v['label_list'] = [];
                    }

                    $v['hascount'] = 0;

                    $v['cover'] = "http://".\Yii::$app->request->hostName.$v['cover'];

                    $category[$key]['dishes'][] = $v;

                    unset($dishes[$k]);
                }
            }
        }

        return $this->asJson(['store'=>$store,'category'=>$category]);

    }

    //提交购物车
    public function actionSubmitCart($sid,$tid)
    {
        $postData = \Yii::$app->request->post();

        $store = Stores::findOne($sid);

        $model = new Dishcart();
        $model->ownerid = $store->ownerid;
        $model->store_id = $sid;
        $model->openid = $postData['openid'];
        $model->list = json_encode($postData['res_list']);
        $model->type = 1;
        $model->tid = $tid;
        if($model->validate() && $model->save()){
            $return = ['success'=>true,'msg'=>'提交成功！'];
        }else{
            $return = ['success'=>false,'msg'=>'提交失败！'];
        }
        return $this->asJson($return);
    }





}