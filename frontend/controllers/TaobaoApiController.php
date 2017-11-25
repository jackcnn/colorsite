<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/10 0010
 * Time: 19:11
 */
namespace frontend\controllers;

use Yii;
use frontend\controllers\BaseController;
use yii\helpers\ArrayHelper;
use yii\helpers\ColorHelper;
use yii\helpers\CurlHelper;
use yii\helpers\Url;
use common\vendor\taobaoke\TaobaokeApiHelper;

class TaobaoApiController extends BaseController
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {

        $sid=0;
        $tid=1;

        //\common\models\Dishcart::updateAll(['isdone'=>1],['isdone'=>0,'store_id'=>$sid,'tid'=>$tid,'created_at'=>['>','created_at',time()]]);

        \common\models\Dishcart::updateAll(['isdone'=>1],"`isdone`=0 and `store_id`=:sid and `tid`=:tid and `created_at`>=:time",
            [':sid'=>$sid,':tid'=>$tid,':time'=>time()-3600*4]
        );

        return $this->render('index');

    }

    //$favorites_id 选品库id
    public function actionList($favorites_id,$page=1,$allow_cache=false)
    {
        $asJson['success'] = true;
        try{
            $cache = \Yii::$app->filecache;
            $list = $cache->get('tkapi_list_'.$favorites_id);
            if(!$allow_cache || !$list){
                $res  = TaobaokeApiHelper::getlist($favorites_id,$page);
                $res = ArrayHelper::toArray($res);
                if(isset($res['results']['uatm_tbk_item']) && count($res['results']['uatm_tbk_item'])){
                    $list = $res['results']['uatm_tbk_item'];
                }else{
                    throw new \Exception('暂无信息！');
                }
                //ArrayHelper::multisort($list,'favorites_id');
                if($list){
                    $cache->set('tkapi_list_'.$favorites_id,$list);
                    $asJson['list'] = $list;
                }else{
                    throw new \Exception('网络错误！');
                }
            }
        }catch (\Exception $e){
            $asJson['success'] = false;
            $asJson['msg'] = $e->getMessage();
        }
        return $this->asJson($asJson);
    }

    //获取分类，其实是淘宝联盟后台的选品库列表
    public function actionCategory($allow_cache=true)
    {
        $asJson['success'] = true;
        try{
            $cache = \Yii::$app->filecache;
            $category = $cache->get('tkapi_category');
            if(!$allow_cache || !$category){
                $res  = TaobaokeApiHelper::getcategory();

                $res = ArrayHelper::toArray($res);

                if(isset($res['results']['tbk_favorites']) && count($res['results']['tbk_favorites'])){
                    $category = $res['results']['tbk_favorites'];
                }else{
                    throw new \Exception('暂无信息！');
                }

                ArrayHelper::multisort($category,'favorites_id');
                if($category){
                    $cache->set('tkapi_category',$category);
                }else{
                    throw new \Exception('网络错误！');
                }
            }
            $asJson['category'] = $category;
        }catch (\Exception $e){
            $asJson['success'] = false;
            $asJson['msg'] = $e->getMessage();
        }
        return $this->asJson($asJson);
    }



    public function actionExcel(){

    }
}