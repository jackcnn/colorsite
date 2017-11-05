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
use common\models\Printer;
use common\models\Stores;
use Yii;
use frontend\controllers\BaseController;
use yii\data\Pagination;
use yii\helpers\ColorHelper;
use yii\helpers\CurlHelper;
use yii\helpers\Url;

class IndexController extends BaseController
{
    public $enableCsrfValidation = false;

    public $appid = "wx0dd0829415ec47da";
    public $appsecret = "d28911cd2ad0a767bb76e7ab237f3656";

    //登陆
    public function actionLogin($code)
    {
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$this->appid."&secret=".$this->appsecret."&js_code=".$code."&grant_type=authorization_code";
        $res = CurlHelper::callWebServer($url);
        return $this->asJson($res);
    }


    //门店列表，暂时不弄
    public function actionIndex($sid,$tid)
    {
        echo 1231;die;
    }
    //扫码进入点餐列表--顾客版
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

                    $v['cover'] = \Yii::$app->request->hostInfo.$v['cover'];

                    $category[$key]['dishes'][] = $v;

                    unset($dishes[$k]);
                }
            }
        }

        $isCart = $this->checkIsCart($sid,$tid);

        return $this->asJson(['store'=>$store,'category'=>$category,'isCart'=>$isCart]);

    }

    //客户提交购物车
    public function actionSubmitCart($sid,$tid)
    {
        $postData = \Yii::$app->request->post();

        $store = Stores::findOne($sid);

        $model = new Dishcart();
        $model->ownerid = $store->ownerid;
        $model->store_id = $sid;
        $model->openid = $postData['openid'];
        $model->list = json_encode($postData['res_list']);
        $model->type = 0;
        $model->st = 0;
        $model->tid = $tid;
        if($model->validate() && $model->save()){
            $return = ['success'=>true,'msg'=>'提交成功！'];
        }else{
            $return = ['success'=>false,'msg'=>'提交失败！'];
        }
        return $this->asJson($return);
    }

    public function actionBindClerk($sid,$clerkid,$openid='',$nickName='',$avatarUrl='')
    {
        $store = Stores::findOne($sid);

        $clerk = Clerk::findOne($clerkid);

        if(strlen($openid)>1){
            $clerk->openid = $openid;
            $clerk->wxname = $nickName;
            $clerk->avatar = $avatarUrl;
            if($clerk->validate() && $clerk->save()){
                return $this->asJson(['success'=>true]);
            }else{
                return $this->asJson(['success'=>false]);
            }
        }

        return $this->asJson(['store'=>$store,'clerk'=>$clerk]);

    }

    //店员点餐页面
    public function actionShowCart($sid,$tid)
    {
        $store = Stores::find()->where(['id'=>$sid])->asArray()->one();
        $cart = Dishcart::find()->where(["store_id"=>$sid,"tid"=>$tid,"isdone"=>0])->asArray()->orderBy("type asc")->all();
        $cartlist = [];
        $i=0;
        $total = 0;
        $total_count=0;
        foreach($cart as $key=>$value){
            $list = json_decode($value['list'],1);
            foreach ($list as $k=>$v){
                $cartlist[$v['id']]["id"]= $v['id'];
                $cartlist[$v['id']]["hascount"] = $v['count'];
                $cartlist[$v['id']]["type"] = $value['type'];
                $cartlist[$v['id']]["labels"] = $v['lable']?substr($v['lable'],1):'';
                $cartlist[$v['id']]["name"] = $v['name'];
                $cartlist[$v['id']]["price"] = $v['price'];
                $total = $total + $v['price']*$v['count'];
                $total_count = $total_count + $v['count'];
                $i++;
            }
        }


        $store = Stores::find()->where(['id'=>$sid])->asArray()->one();

        $category = Category::find()->where(['table'=>'restaurant'])->asArray()->orderBy("sort,id")->all();

        $dishes = Dishes::find()->where(['ownerid'=>$store['ownerid']])->asArray()->orderBy("sort,id")->all();
        $alldishes = $dishes;
        foreach($category as $key=>$value){
            foreach($dishes as $k=>$v){
                if($v['cateid'] == $value['id']){

                    if(isset($cartlist[$v['id']])){
                        $cartinfo=$cartlist[$v['id']];
                        $v['get_labels'] = $cartinfo['labels'];
                        $v['hascount'] = $cartinfo['hascount'];
                    }else{

                        $v['get_labels'] = '';
                        $v['hascount'] = 0;

                    }

                    $v['cover'] = \Yii::$app->request->hostInfo.$v['cover'];

                    $category[$key]['dishes'][] = $v;

                    unset($dishes[$k]);
                }
            }
        }

        return $this->asJson(['category'=>$category,'total'=>$total,'total_count'=>$total_count,'store'=>$store]);
    }

    //店员提交打印菜单
    public function actionClerkSubcart($sid,$tid)
    {
        $res_list = \Yii::$app->request->post("res_list");

        $total = \Yii::$app->request->post("total");

        $model = Dishcart::find()->where(["store_id"=>$sid,"tid"=>$tid,"isdone"=>0])->orderBy("id desc")->one();

        if(!$model){
            $model = new Dishcart();
            $store = Stores::findOne($sid);
            $model->ownerid = $store->ownerid;
            $model->store_id = $sid;
            $model->type = 0;
            $model->st = 0;
            $model->tid = $tid;
        }

        $model->list = json_encode($res_list);

        if($model->validate() && $model->save()){

            //打印订单

            $content = '';                          //打印内容
            $content .= '<FS><center>'.$tid.'号</center></FS>';
            $content .= str_repeat('-',32);
            $content .= '<table>';
            $content .= '<tr><td>菜品</td><td>数量</td><td>价格</td></tr>';
            foreach($res_list as $key=>$value){
                if(isset($value['name'])){
                    $price = intval($value['price']*$value['count'])/100;
                    $content .= '<tr><td>'.$value['name'].'</td><td>'.$value['count'].'</td><td>'.$price.'元</td></tr>';
                }
                if(isset($value['lable']) && strlen($value['lable'])> 1){
                    $content .= '<tr><td></td><td></td><td>('.$value['lable'].')</td></tr>';
                }
            }
            $content .= '</table>';
            $content .= str_repeat('-',32)."\n";
            $content .= "<FS>总金额: ".($total/100)."元</FS>\r\n";

            $this->printer_content($sid,$content);


            $return = ['success'=>true,'msg'=>'提交成功！'];
        }else{
            $return = ['success'=>false,'msg'=>'提交失败！'];
        }
        return $this->asJson($return);


    }

    //店员提交订单页面
    public function actionCreateOrder($sid,$tid)
    {
        $openid = \Yii::$app->request->post("openid");
        $truepay = \Yii::$app->request->post("truepay");
        $type = \Yii::$app->request->post("type");
        $res_list = \Yii::$app->request->post("res_list");

        $store = Stores::findOne($sid);

        $model = new Dishorder();

        $model->ownerid = $store->ownerid;
        $model->store_id = $sid;
        $model->ordersn = ColorHelper::orderSN($sid.$tid);
        $model->sn = $model->ordersn;
        $model->amount = intval($truepay*100);
        $model->list = json_encode($res_list);
        $model->openid = $openid;
        $model->table_num = $tid;
        $model->paytype = $type;

        if($type == "weixin"){
            $model->status = 1;//可付款
        }else{
            $model->status = 2;//其他方式，已付款
            $model->paytime = time();
            $model->payopenid = $openid;
            $model->payinfo = json_encode(['msg'=>'其他方式付款的']);
        }
        if($model->validate() && $model->save()){

            //把菜品购物车设置过期
            \Yii::$app->db->createCommand()->update('{{%dishcart}}', ['isdone' => 1], ['store_id'=>$sid,'tid'=>$tid])->execute();


            $return = ['success'=>true,'msg'=>'提交成功！','orderid'=>$model->id,'ordersn'=>$model->ordersn];
        }else{
            $return = ['success'=>false,'msg'=>'提交失败！'];
        }
        return $this->asJson($return);

    }


    //定位页面
    public function actionRouter($sid,$tid)
    {
        $openid = \Yii::$app->request->post("openid");

        $clerk = Clerk::find()->where(['openid'=>$openid,'store_id'=>$sid])->count();

        if($clerk){//如果是店员，则进入帮助点餐页面

            $role = "clerk";

        }else{//顾客，进入自助点餐页面

            $role = "customer";

        }

        return $this->asJson(['role'=>$role]);
    }

    public function actionPrintCart($sid,$tid)
    {

        $postData = \Yii::$app->request->post();

        $content = '';                          //打印内容
        $content .= '<FS><center>'.$tid.'号</center></FS>';
        $content .= str_repeat('-',32);
        $content .= '<table>';
        $content .= '<tr><td>菜品</td><td>数量</td><td>价格</td></tr>';
        foreach($postData['cartlist'] as $key=>$value){
            if(isset($value['name'])){
                $price = intval($value['price']*$value['hascount'])/100;
                $content .= '<tr><td>'.$value['name'].'</td><td>'.$value['hascount'].'</td><td>'.$price.'元</td></tr>';
            }
            if(isset($value['labels']) && strlen($value['labels'])> 1){
                $content .= '<tr><td></td><td></td><td>('.$value['labels'].')</td></tr>';
            }
        }
        $content .= '<tr><td>茶位费</td><td></td><td>'.$postData['inputValue'].'</td></tr>';
        $content .= '</table>';
        $content .= str_repeat('-',32)."\n";
        $content .= "<FS>总金额: ".($postData['total']+$postData['inputValue'])."元</FS>\r\n";

        $this->printer_content($sid,$content);

    }


    public function checkIsCart($sid,$tid)
    {
        //当时点菜记录
        $model = Dishcart::find()->where([
            "store_id"=>$sid,
            "tid"=>$tid,
            "type"=>0,
            "isdone"=>0,
        ])->andWhere([">","created_at",time()-3600*4])->orderBy("id DESC")->one();

        if($model){
            return true;
        }else{
            return false;
        }

    }

    public function printer_content($store_id,$content){
        //把所有打印机
        //$printers = Printer::find()->where(['store_id'=>$store_id,'isuse'=>1])->asArray()->all();
        $printers = Printer::find()->where(['store_id'=>$store_id,'isuse'=>1])->asArray()->all();


        foreach($printers as $key=>$value){
            $actions = json_decode($value['actions'],1);
            if(in_array("dishes",$actions)){//选为打印的，开始打印
                $machineCode = $value['machine_code'];                      //授权的终端号
                $res = \common\vendor\yilianyun\YilianyunHelper::printer($content,$machineCode);
                return $res;
                if($res == 'success'){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    //打印菜单
    public function print_dishes($dishes,$order,$token)
    {

        $content = '';                          //打印内容
        $content .= '<FS><center>'.$order->table_num.'号</center></FS>';
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

}