<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14 0014
 * Time: 12:17
 */

namespace frontend\modules\tbk\controllers;
use Codeception\Codecept;
use common\models\Taobaolist;
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

class HotSaleController extends BaseController
{
    public $enableCsrfValidation = false;

    public $limit=10;

    public function actionIndex($keyword='',$page=1)
    {
        $limit = $this->limit;
        $list = Taobaolist::find()->offset(($page-1)*$limit)->limit($limit)
            ->andFilterWhere(['like','title',$keyword])
            ->orderBy("sale DESC")->asArray()->all();

        return $this->renderPartial("index",[
            'list'=>$list
        ]);
    }

    public function actionLists($kw='',$page=1)
    {
        $limit = $this->limit;
        $list = Taobaolist::find()->offset(($page-1)*$limit)->limit($limit)
            ->andFilterWhere(['like','title',$kw])
            ->orderBy("sale DESC")->asArray()->all();
        echo $this->renderPartial("lists",[
            'list'=>$list
        ]);
    }



    //生成淘口令
    public function actionKoulin($url)
    {
        $asJson['success'] = true;
        try{
            $res = TaobaokeApiHelper::taokoulin(urldecode($url));
            $res = ArrayHelper::toArray($res);
            if(isset($res['data']['model'])){
                $asJson['data'] = $res['data']['model'];
            }else{
                throw new \Exception($res['sub_msg']);
            }
        }catch (\Exception $e){
            $asJson['success'] = false;
            $asJson['msg'] = $e->getMessage();
        }
        return $this->asJson($asJson);
    }







}