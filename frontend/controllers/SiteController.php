<?php
namespace frontend\controllers;

use common\models\Category;
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

class SiteController extends BaseController
{
    public $enableCsrfValidation = false;

    public $openid = "SA523BER";

    public function actionIndex()
    {
        ColorHelper::wxlogin($this->ownerid);

        $store = Stores::find()->where(['ownerid'=>$this->ownerid,'id'=>\Yii::$app->request->get("store_id")])->asArray()->one();

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

    //本地cookies 存储一下
    public function actionCookiesorder($store_id)
    {
        $list = \Yii::$app->request->post("list");
        $sn = \Yii::$app->request->post("sn");
        $dish_list = [];
        foreach($list as $key=>$value){
            $data = explode("-",$value);
            $dish_list[$data[0]] = $data[1];
        }

        $data = json_encode($dish_list);

        $cookies = \Yii::$app->response->cookies;

        $cookies->add(new \yii\web\Cookie([
            'name' => 'dish'.$store_id.'cart'.$sn,
            'value' => $data,
        ]));

        $res['location']=Url::to(['site/preorder','store_id'=>$store_id,'token'=>$this->token,'sn'=>$sn]);

        return $this->asJson($res);
    }

    public function actionPreorder($store_id,$sn)
    {
        $store = Stores::find()->where(['id'=>$store_id,'ownerid'=>$this->ownerid])->one();
        $cookies = Yii::$app->request->cookies;
        $list = $cookies->getValue('dish'.$store_id.'cart'.$sn);
        $list = json_decode($list,1);
        if(!$list){
            $list = [];
        }
        $ids = [];
        $count_list = [];
        foreach($list as $key=>$value){
            $ids[]=$key;
            $count_list[$key]=$value;
        }

        $dishes = Dishes::find()->where(['ownerid'=>$this->ownerid])
            ->andWhere(['in','id',$ids])->asArray()->all();
        $total = 0 ;
        foreach($dishes as $key=>$value){
            $dishes[$key]['order_count'] = $count_list[$value['id']];

            $dishes[$key]['order_single_amount'] = intval($count_list[$value['id']]*$value['price']);

            if($value['labes']){
                $dishes[$key]['labels'] = explode(",",$value['labes']);
            }else{
                $dishes[$key]['labels'] = [];
            }

            $total = $total + $dishes[$key]['order_single_amount'];

        }
        return $this->renderPartial("preorder",[
            'dishes'=>$dishes,
            'total'=>$total,
            'store'=>$store,
        ]);
    }

    public function actionSaveorder($store_id,$sn)
    {
        $request = \Yii::$app->request;
        if($request->isPost){
            $post = $request->post();
            $ids = isset($post['ids'])?$post['ids']:[];
            $count = isset($post['count'])?$post['count']:[];
            $labels = isset($post['labels'])?$post['labels']:[];

            if(count($ids)){
                $data = [];
                foreach($ids as $key=>$value){
                    $data[$key]['id'] = $value;
                    $data[$key]['count'] = $count[$key];
                    $data[$key]['labels'] = $labels[$key];
                }

                $model = Dishcart::find()->where([
                    'store_id'=>$store_id,
                    'sn'=>$sn,
                    'openid'=>\Yii::$app->user->identity->openid,
                    'type'=>0 //第一次点餐
                ])->one();

                if(!$model){
                    $model = new Dishcart();
                }

                $model->store_id = $store_id;
                $model->ownerid = $this->ownerid;
                $model->openid = \Yii::$app->user->identity->openid;
                $model->name = \Yii::$app->user->identity->wxname;
                $model->sn = $sn;
                $model->list = json_encode($data);
                $model->mark = $post['mark'];

                if($model->validate() && $model->save()){
                    return $this->redirect(['site/resorder','store_id'=>$store_id,'sn'=>$sn,'token'=>$this->token]);
                }
            }else{
                $model = Dishcart::find()->where([
                    'store_id'=>$store_id,
                    'sn'=>$sn,
                    'openid'=>\Yii::$app->user->identity->openid,
                    'type'=>0
                ])->one();
                if($model){
                    $model->delete();
                }

            }
        }

    }

    //所有人的点餐列表
    public function actionResorder($store_id,$sn)
    {
        $store = Stores::find()->where(['id'=>$store_id,'ownerid'=>$this->ownerid])->one();
        $carts = Dishcart::find()->where(['store_id'=>$store_id,'sn'=>$sn,'ownerid'=>$this->ownerid])->orderBy("id asc")->asArray()->all();

        $dish_ids = [];
        foreach($carts as $key=>$value){
            $list = json_decode($value['list'],1);

            foreach($list as $k=>$v){
                $dish_ids[]=$v['id'];
                $carts[$key]['dish_ids'][]=$v['id'];
            }

        }
        $dishes = Dishes::find()->where(['ownerid'=>$this->ownerid])
            ->andWhere(['in','id',$dish_ids])->asArray()->all();
        $new_dishes = [];
        foreach($dishes as $key=>$value){
            $new_dishes[$value['id']]=$value;
        }
        unset($dishes);

        $total = 0;

        foreach($carts as $key=>$value){
            $list = json_decode($value['list'],1);

            $cart_dishes = [];

            foreach($list as $k=>$v){
                $cart_dishes[$v['id']] = $new_dishes[$v['id']];
                $cart_dishes[$v['id']]['order_count'] = $v['count'];
                $cart_dishes[$v['id']]['order_labels'] = $v['labels'];
                $cart_dishes[$v['id']]['order_single_amount'] = intval($v['count']*$new_dishes[$v['id']]['price']);

                $total = $total + intval($v['count']*$new_dishes[$v['id']]['price']);

            }

            $carts[$key]['dishes'] = $cart_dishes;

        }

        return $this->renderPartial("resorder",[
            'carts'=>$carts,
            'total'=>$total,
            'store'=>$store,
        ]);

    }


    public function actionSell()
    {

        echo phpinfo();
    }
}
