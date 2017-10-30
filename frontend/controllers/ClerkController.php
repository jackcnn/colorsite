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
use common\models\Printer;
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
                return $this->redirect(['clerk/msg','token'=>$this->token,'type'=>'error','msg'=>urlencode("订单金额错误？请重试")]);
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
                $this->print_dishes($dishes,$order,$this->token);

                return $this->redirect(['clerk/msg','token'=>$this->token,'type'=>'success','msg'=>urlencode('下单成功！小票已打印，编号'.$order->id)]);

            }else{
                return $this->redirect(['clerk/msg','token'=>$this->token,'type'=>'error','msg'=>urlencode(current($order->getFirstErrors()))]);
            }

        }
    }

    //打印菜单
    public function print_dishes($dishes,$order,$token)
    {

        $content = '';                          //打印内容
        $content .= '<FS><center>'.$order->table_num.'号桌</center></FS>';
        $content .= str_repeat('-',32);
        $content .= '<table>';
        $content .= '<tr><td>菜品</td><td>数量</td><td>价格</td></tr>';
        foreach($dishes as $key=>$value){
            if(isset($value['name'])){
                $price = intval($value['price']*$value['count'])/100;
                $content .= '<tr><td>'.$value['name'].'</td><td>'.$value['count'].'</td><td>'.$price.'元</td></tr>';
            }
            if(isset($value['labels']) && strlen($value['labels'])> 1){
                $content .= '<tr><td></td><td></td><td>('.$value['labels'].')</td></tr>';
            }
        }
        $content .= '</table>';
        $content .= str_repeat('-',32)."\n";
        $content .= "<FS>总金额: ".($order->amount/100)."元</FS>\r\n";
        $content .= "订单编号：".$order->id."\r\n\r\n";

        $qrcode = Url::to(['/site/index','token'=>$token,'store_id'=>$order->store_id,'sn'=>$order->ordersn],true);

        $content .= "<center><QR>".$qrcode."</QR></center>";


        //把所有打印机
        $printers = Printer::find()->where(['store_id'=>$order->store_id,'isuse'=>1])->asArray()->all();

        foreach($printers as $key=>$value){
            $actions = json_decode($value['actions'],1);
            if(in_array("dishes",$actions)){//选为打印的，开始打印
                $machineCode = $value['machine_code'];                      //授权的终端号
                $res = \common\vendor\yilianyun\YilianyunHelper::printer($content,$machineCode);
                if($res == 'success'){
                    return true;
                }else{
                    return false;
                }
            }
        }

    }

    //打印二维码
    public function actionPrintCode()
    {

        ColorHelper::wxlogin($this->ownerid);

        $clerk = Clerk::find()->where(['openid'=>\Yii::$app->user->identity->openid])->one();
        $right = false;
        if(!$clerk){
            $right = false;
        }else{
            $store = Stores::findOne($clerk->store_id);

            $actions = json_decode($clerk->rights,1);

            if(in_array("printcode",$actions)){
                $right = true;
            }else{
                $right = false;
            }
        }

        return $this->renderPartial("print-code",[
            'store'=>$store,
            'clerk'=>$clerk,
            'right'=>$right
        ]);

    }

    public function actionPrinting()
    {
        $return['success']=true;
        $request=\Yii::$app->request;
        try{
            $user= \Yii::$app->user;
            $identity=$user->identity;
            if($user->isGuest){
                throw new \Exception('请先登录');
            }
            if(!$request->isPost){
                throw new \Exception('非法请求');
            }

            $clerk = Clerk::find()->where(['openid'=>\Yii::$app->user->identity->openid])->one();
            $right = false;
            if(!$clerk){
                $right = false;
            }else{
                $store = Stores::findOne($clerk->store_id);
                $actions = json_decode($clerk->rights,1);
                if(in_array("printcode",$actions)){
                    $right = true;
                }else{
                    $right = false;
                }
            }
            if(!$right){
                throw new \Exception('无权限');
            }

            //把所有打印机
            $printers = Printer::find()->where(['store_id'=>$clerk->store_id,'isuse'=>1])->asArray()->all();

            //$str = "https://326108993.com/site/index.html?store_id=1&token=bRGqRLRqA&sn=".ColorHelper::orderSN(2);
            $str = Url::to(['/site/index','store_id'=>$store->id,'token'=>ColorHelper::id2token($clerk->ownerid),'sn'=>ColorHelper::orderSN($store->id)],true);
            $content = "";
            $content .= "<FS><center>微信扫码点餐</center></FS>";
            $content .= str_repeat('-',32);
            $content .= "1.和好友一起扫码共同点餐\r\n";
            $content .= "2.大家都点好后提交即可呼叫服务员确认下单\r\n";
            $content .= "3.用餐结束呼叫服务员买单\r\n";
            $content .= "4.服务员确认买单\r\n";
            $content .= "5.重新扫码即可微信支付订单，最后完成\r\n";
            $content .= "门店：".$store->name."\r\n";
            $content .= "<center><QR>".$str."</QR></center>";


            foreach($printers as $key=>$value){
                $actions = json_decode($value['actions'],1);
                if(in_array("qrcode",$actions)){//选为打印的，开始打印
                    $machineCode = $value['machine_code'];                      //授权的终端号
                    $res = \common\vendor\yilianyun\YilianyunHelper::printer($content,$machineCode);
                    if($res == 'success'){
                        $return['msg'] = "打印成功！".$str;
                    }else{
                        throw new \Exception('打印失败！'.$res);
                    }
                }
            }
        }catch (\Exception $e){
            $return['success']=false;
            $return['msg']=$e->getMessage();
        }
        return $this->asJson($return);

    }

    public function actionMsg()
    {
        return $this->renderPartial("msg");
    }
}
