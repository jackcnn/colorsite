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
        foreach($cart as $key=>$value){
            $list = json_decode($value['list'],1);
            foreach ($list as $k=>$v){
                $cartlist[]["id"]= $v['id'];
                $cartlist[]["hascount"] = $v['count'];
                $cartlist[]["type"] = $value['type'];
                $cartlist[]["labels"] = $v['lable'];
                $cartlist[]["name"] = $v['name'];
                $cartlist[]["price"] = $v['price'];
            }
        }

        return $this->asJson($cartlist);



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

}