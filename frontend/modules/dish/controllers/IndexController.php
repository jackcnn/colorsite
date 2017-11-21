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
use yii\helpers\Html;
use yii\helpers\Url;

class IndexController extends BaseController
{
    public $enableCsrfValidation = false;

    public $appid = CHENGLAN_DIANCAN_APPID;
    public $appsecret = CHENGLAN_DIANCAN_APPSECRET;

    //登陆
    public function actionLogin($code)
    {
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$this->appid."&secret=".$this->appsecret."&js_code=".$code."&grant_type=authorization_code";
        $res = CurlHelper::callWebServer($url);
        return $this->asJson($res);
    }

    //定位页面--扫描的二维码都是从这里再进到其他的页面
    public function actionRouter($sid,$tid)
    {
        $openid = \Yii::$app->request->get("openid","openid");

        $clerk = Clerk::find()->where(['openid'=>$openid,'store_id'=>$sid])->one();

        $cart = Dishcart::find()->where(['store_id'=>$sid,'tid'=>$tid,'isdone'=>0])->one();

        $store = Stores::findOne($sid);

        //如果店铺选择了付款打单，就跳到这里来
        if($store->needpay>0){
            //$path = "/page/main/pages/customer/index?sid=".$sid."&tid=".$tid;
            $path = "/page/self/index?sid=".$sid."&tid=".$tid;
            return $this->asJson(['role'=>'customer','path'=>$path]);
        }


        $order = Dishorder::find()->where(['store_id'=>$sid,'table_num'=>$tid])
            ->andWhere(['>',"created_at",time()-3600*4])
            ->orderBy("id desc,created_at desc")->one();
        //找到餐牌对应的最新一条订单记录
        if($order){
            if(intval($order->status) == 2 && $order->paytime){
                $haspay = true;
            }else{
                $haspay = false;
            }
        }else{
            $haspay = false;
        }

        if($clerk){//如果是店员，则进入帮助点餐页面

            $role = "clerk";

            if($order){//如果已经生成支付订单了，就调到等待支付的页面sid=1&tid=33&orderid=31&ordersn=171106151917001335310
                if($haspay){//订单已支付的，已经完成了上一个交易了
                    $path = "/page/main/pages/clerk/index?sid=".$sid."&tid=".$tid;
                }else{
                    $path = "/page/main/pages/checkpay/index?sid=".$sid."&tid=".$tid."&orderid=".$order->id."&ordersn=".$order->ordersn;
                }
            }else{
                $path = "/page/main/pages/clerk/index?sid=".$sid."&tid=".$tid;

            }

        }else{//顾客，进入自助点餐页面

            $role = "customer";

            //默认进入点菜页面
            $path = "/page/main/pages/customer/index?sid=".$sid."&tid=".$tid;

            if($cart){ // 查看点单的页面
                $path = "/page/main/pages/orderdishes/index?sid=".$sid."&tid=".$tid;
            }
            if($order){ // 付款页面 sid=1&tid=33&orderid=20&ordersn=171105184653001331005
                if(!$haspay){
                    $path = "/page/main/pages/pay/index?sid=".$sid."&tid=".$tid."&orderid=".$order->id."&ordersn=".$order->ordersn;
                }
            }

        }
        return $this->asJson(['role'=>$role,'path'=>$path]);
    }


    //门店列表
    public function actionMchList($lat=0,$lng=0,$keyword="")
    {

        $distance="ROUND(6378.138*2*ASIN(SQRT(POW(SIN((".$lat."*PI()/180-lat*PI()/180)/2),2)+COS(".$lat."*PI()/180)*COS(lat*PI()/180)*POW(SIN((".$lng."*PI()/180-lng*PI()/180)/2),2)))*1000) AS `distance` ";

        $query = Stores::find()->where([">","ownerid",0])
            ->select("*,".$distance)
            ->orderBy("distance")
            ->andWhere(["<>","name",""])->andFilterWhere(["like","name",urldecode($keyword)]);

        $list = $query->asArray()->all();

        if(!$list){
            $list = [];
        }

        return $this->asJson(['list'=>$list]);

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
        $cart = Dishcart::find()->where(["store_id"=>$sid,"tid"=>$tid,"isdone"=>0])->asArray()->orderBy("id desc,type asc")->all();
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

        //$total = \Yii::$app->request->post("total");

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

        $total = 0 ;

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

                    $total = $total + $price;

                }
                if(isset($value['lable']) && strlen($value['lable'])> 1){
                    $content .= '<tr><td></td><td></td><td>('.$value['lable'].')</td></tr>';
                }
            }
            $content .= '</table>';
            $content .= str_repeat('-',32)."\n";
            $content .= "<FS>总金额: ".$total."元</FS>\r\n";
            $content .= "时间: ".date('Y-m-d H:i:s',time())."\r\n";

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
        $formId = \Yii::$app->request->post("formId");
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
        $model->formid = $formId;
        $model->status = 1;//可付款
        if($type == "wxpay"){
            $model->status = 1;//可付款
        }elseif($type == "other"){
            $model->status = 2;//其他方式，已付款
            $model->paytime = time();
            $model->payopenid = $openid;
            $model->payinfo = json_encode(['msg'=>'其他方式付款的']);
        }
        if($model->validate() && $model->save()){

            //把菜品购物车设置过期
            \Yii::$app->db->createCommand()->update('{{%dishcart}}', ['isdone' => 1], ['store_id'=>$sid,'isdone'=>0,'tid'=>$tid])->execute();


            $return = ['success'=>true,'msg'=>'提交成功！','orderid'=>$model->id,'ordersn'=>$model->ordersn];
        }else{
            $return = ['success'=>false,'msg'=>'提交失败！'];
        }
        return $this->asJson($return);

    }

    //获取订单详情
    public function actionOrderDetail($sid,$tid,$orderid,$ordersn)
    {
        $data['success'] = true;
        try{
            $model = Dishorder::find()->where(['store_id'=>$sid,'id'=>$orderid,'ordersn'=>$ordersn])->asArray()->one();
            $store = Stores::find()->where(['id'=>$sid])->asArray()->one();
            $data['store'] = $store;
            if(!$model){
                throw new \Exception('订单不存在！');
            }

//            if($model['status'] > 1 && $model['paytime']>0){
//                throw new \Exception('订单已支付！');
//            }

            $model['list'] = json_decode($model['list'],1);
            $model['format_paytime'] = $model['paytime']>0?date("Y-m-d H:i:s",$model['paytime']):'';

            $model['paytype_name'] = $model['paytype']=="wxpay"?"微信支付":"其他支付方式";

            $data['order'] = $model;

        }catch (\Exception $e){
            $data['success'] = false;
            $data['msg'] = $e->getMessage();
        }

        return $this->asJson($data);


    }

    //微信支付页面
    public function actionPayOrder($orderid,$ordersn)
    {

        $model = Dishorder::find()->where(['id'=>$orderid,'ordersn'=>$ordersn])->one();

        $model->status = 2;
        $model->paytime = time();

        $store = Stores::findOne($model->store_id);

        $model->save();
        //发送小程序模板信息-这里是发送给店员的
        $access_token=ColorHelper::CHENGLAN_DIANCAN_ACCESSTOKEN();
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=$access_token";
        $send_data['touser'] = $model->openid;
        $send_data['template_id'] = "yO4GOBrdXTQVMS0b4C5uw9QPz8YIRRxehsKmYB6XO00";
        $send_data['form_id'] = $model->formid;
        $send_data['data'] = [
            'keyword1'=>['value'=>$model->amount/100,'color'=>'#173177'],
            'keyword2'=>['value'=>date("Y-m-d H:i:s",$model->paytime),'color'=>'#173177'],
            'keyword3'=>['value'=>$store->name,'color'=>'#173177'],
        ];
        $send_data['emphasis_keyword'] = "keyword1.DATA";
        $res = CurlHelper::callWebServer($url,json_encode($send_data),"post",false);
    }

    //订单列表
    public function actionOrderList($openid)
    {
        $list = Dishorder::find()->where(['openid'=>$openid,'status'=>2])
            ->andWhere([">","created_at",time()-3600*24*90])
            ->andWhere([">","paytime",0])
            ->asArray()->orderBy("created_at desc")->all();

        foreach ($list as $key=>$value){

            $list[$key]['format_time'] = date("Y-m-d H:i:s",$value['paytime']);

        }

        return $this->asJson(['list'=>$list]);

    }


    //提交订单支付后打印
    public function actionSubmitOrder($sid,$tid)
    {
        ColorHelper::dump(\Yii::$app->request->post());


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

    public function actionJokeList()
    {
        $data= (new \yii\db\Query())
            ->select(['title', 'desc'])
            ->from('{{%jokes}}')
            ->orderBy("rand()")
            ->limit(10)
            ->all();
        foreach ($data as $key=>$value){
            $data[$key]['desc'] = str_replace("</p>","",str_replace("<p>","",$value['desc']));
        }


        return $this->asJson(['list'=>$data]);
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