<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/11 0011
 * Time: 15:11
 */

namespace frontend\modules\tbk\controllers;
use phpDocumentor\Reflection\Types\String_;
use Yii;
use frontend\controllers\BaseController;
use yii\helpers\ColorHelper;
use yii\helpers\CurlHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\vendor\taobaoke\TaobaokeApiHelper;

class IndexController extends BaseController
{
    public $enableCsrfValidation = false;

    public $appid = TBK_APPID;
    public $appsecret = TBK_APPSECRET;

    //登陆
    public function actionLogin($code)
    {
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$this->appid."&secret=".$this->appsecret."&js_code=".$code."&grant_type=authorization_code";
        $res = CurlHelper::callWebServer($url);
        return $this->asJson($res);
    }

    public function actionIndex()
    {

        $category = $this->category();

        $list = $this->getLists($category[0]['favorites_id']);

//        ColorHelper::dump($list);
        if(!is_array($list)){
            $list =[];
        }

        return $this->asJson(['list'=>$list,'category'=>$category]);
    }

    public function actionLists($favorites_id,$page)
    {
        $list = $this->getLists($favorites_id,$page);

        if(!is_array($list)){
            $list =[];
        }

        return $this->asJson(['list'=>$list]);

    }


    //获取分类，其实是淘宝联盟后台的选品库列表
    public function category($allow_cache=true)
    {
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
            return $category;
        }catch (\Exception $e){
//            $asJson['success'] = false;
//            $asJson['msg'] = $e->getMessage();
            return $e->getMessage();
        }


    }

    public function getLists($favorites_id,$page=1,$allow_cache=false)
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
                if($list){
                    $cache->set('tkapi_list_'.$favorites_id,$list);
                    $asJson['list'] = $list;

                }else{
                    throw new \Exception('网络错误！');
                }
            }
            foreach($list as $key=>$value){
                if($value['status']<1){
                    unset($list[$key]);
                }else{
                    $list[$key]['indexTitle'] = StringHelper::truncate($value['title'],25);
                    $list[$key]['small_images'] = $value['small_images']['string'];
                }
            }
            return $list;
        }catch (\Exception $e){
            return $e->getMessage();
        }

    }

    public function detail($favorites_id,$num_iid)
    {
        $asJson['success'] = true;
        try{
            $cache = \Yii::$app->filecache;
            $list = $cache->get('tkapi_list_'.$favorites_id);
            $list = json_decode($list,1);

            $data = $list[$num_iid];
            $asJson['data'] = $data;
        }catch (\Exception $e){
            $asJson['success'] = false;
            $asJson['msg'] = $e->getMessage();
        }
        return $this->asJson($asJson);

    }


}