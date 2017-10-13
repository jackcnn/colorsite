<?php
namespace frontend\controllers;

use common\models\Category;
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

    public function actionSaveorder($store_id)
    {

        $model = new Dishorder();

        $model->store_id = $store_id;
        $model->ownerid = $this->ownerid;
        $model->status = 0;
        //$model->amount = intval(\Yii::$app->request->post("amount"));
        $model->ordersn = ColorHelper::orderSN($store_id);
        $model->openid = "kdjsldk";

        $list = \Yii::$app->request->post("list");
        $dish_list = [];
        foreach($list as $key=>$value){
            $data = explode("-",$value);
            $dish_list[$data[0]] = $data[1];
        }

        $model->list = json_encode($dish_list);

        if($model->validate() && $model->save()){
            $res['location']=Url::to(['site/preorder','store_id'=>$store_id,'token'=>$this->token,'orderid'=>$model->id,'ordersn'=>$model->ordersn]);
        }

        return $this->asJson($res);


    }


    //开始的订单
    public function actionPreorder($store_id,$orderid,$ordersn)
    {

        $store = Stores::find()->where(['id'=>$store_id,'ownerid'=>$this->ownerid])->one();

        $order = Dishorder::find()->where(['id'=>$orderid,'ordersn'=>$ordersn])->one();

        $list = json_decode($order['list'],1);
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

        $order->amount = $total;
        $order->save();

        return $this->renderPartial("preorder",[
            'dishes'=>$dishes,
            'total'=>$total,
            'store'=>$store,
        ]);


    }

    public function actionSell()
    {

        return $this->renderPartial("sell");
    }
}
