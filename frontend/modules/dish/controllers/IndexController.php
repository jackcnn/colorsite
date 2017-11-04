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

                    $v['cover'] = \Yii::$app->request->hostInfo.$v['cover'];

                    $category[$key]['dishes'][] = $v;

                    unset($dishes[$k]);
                }
            }
        }

        $isCart = $this->checkIsCart($sid,$tid);

        return $this->asJson(['store'=>$store,'category'=>$category,'isCart'=>$isCart]);

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
        $model->type = 0;
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

    public function actionShowCart($sid,$tid)
    {

        $store = Stores::find()->where(['id'=>$sid])->asArray()->one();

        $cart = Dishcart::find()->where(["store_id"=>$sid,"tid"=>$tid,"isdone"=>0])->asArray()->orderBy("type asc")->all();

        $cartlist = [];
        $i=0;
        $total = 0;
        foreach($cart as $key=>$value){
            $list = json_decode($value['list'],1);
            foreach ($list as $k=>$v){
                $cartlist[$i]["id"]= $v['id'];
                $cartlist[$i]["hascount"] = $v['count'];
                $cartlist[$i]["type"] = $value['type'];
                $cartlist[$i]["labels"] = $v['lable']?substr($v['lable'],1):'';
                $cartlist[$i]["name"] = $v['name'];
                $cartlist[$i]["price"] = $v['price'];
                $total = $total + $v['price']*$v['count'];
                $i++;
            }
        }

        return $this->asJson(['cartlist'=>$cartlist,'total'=>$total]);

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

        $this->printer_content($content,$sid);

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
        $printers = Printer::find()->where(['store_id'=>$store_id,'isuse'=>1])->createCommand()->getRawSql();

        ColorHelper::dump($printers);die;

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