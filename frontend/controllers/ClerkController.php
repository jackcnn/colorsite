<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/14 0014
 * Time: 15:33
 */
namespace frontend\controllers;

use common\models\Category;
use common\models\Clerk;
use common\models\Dishcart;
use common\models\Dishes;
use common\models\Dishorder;
use common\models\Dishorderopenid;
use common\models\Gallery;
use common\models\Stores;
use Yii;
use frontend\controllers\BaseController;
use yii\data\Pagination;
use yii\helpers\ColorHelper;
use yii\helpers\Url;

class ClerkController extends BaseController
{
    public $enableCsrfValidation = false;

    //店员查看下单信息
    public function actionIndex($store_id,$sn)
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

        return $this->renderPartial("index",[
            'carts'=>$carts,
            'total'=>$total,
            'store'=>$store,
        ]);

    }

    public function actionOrder($store_id,$sn)
    {

        $request = \Yii::$app->request;

        if($request->isPost){
            $postData = $request->post();

            $dishes = $postData['dishes'];//点菜的详细

            $amount = 0 ;

            foreach($dishes as $key=>$value){

                $amount += intval($value['count']*$value['price']);

            }

            if($amount != $postData['amount']){
                return $this->redirect(['clerk/msg','type'=>'error','msg'=>urlencode("订单金额错误？请重试")]);
            }


            $order = Dishorder::find()->where(['ordersn'=>$sn,'store_id'=>$store_id])->one();
            if(!$order){
                $order = new Dishorder();
            }

            $dishes['mark'] = $postData['mark'];

            $order->ownerid = $this->ownerid;
            $order->store_id = $store_id;
            $order->amount = $amount;
            $order->ordersn = $sn;
            $order->sn = $sn;
            $order->status = 0;
            $order->list = json_encode($dishes);
            $order->openid = \Yii::$app->user->identity->openid;
            $order->openid_list = implode(",",$postData['openid']);
            $order->table_num = $postData['tableNo'];

            if($order->validate() && $order->save()){
                foreach($postData['openid'] as $key=>$value){
                    $model = new Dishorderopenid();
                    $model->ownerid = $this->ownerid;
                    $model->store_id = $store_id;
                    $model->orderid = $order->id;
                    $model->openid = $value;
                    $model->save();
                }

                //这里要打印小票

                return $this->redirect(['clerk/msg','type'=>'success','msg'=>urlencode('下单成功！小票已打印，编号'.$order->id)]);

            }else{
                return $this->redirect(['clerk/msg','type'=>'error','msg'=>urlencode(current($order->getFirstErrors()))]);
            }

        }
    }

    public function actionMsg()
    {
        return $this->renderPartial("msg");
    }
}
