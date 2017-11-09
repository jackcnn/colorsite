<?php
namespace frontend\controllers;

use common\models\Baoming;
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

class SiteController extends BaseController
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $request = \Yii::$app->request;
        if($request->isPost){
            $return['success'] = true;
            try{

                if(!$request->post('name') || !$request->post("tel")){
                    throw new \Exception('姓名和手机号必须填！');
                }
                $check = Baoming::find()->where(['tel'=>$request->post('tel')])
                    ->andWhere(['>',"created_at",time()-3600])->count();
                if($check){
                    throw new \Exception('你已提交过了');
                }
                $check1 = Baoming::find()->where(['ip'=>$request->getUserIP()])
                    ->andWhere(['>',"created_at",time()-3600])->count();
                if($check1){
                    throw new \Exception('操作过于频繁');
                }

                $model = new Baoming();
                $model->name = $request->post("name");
                $model->tel = $request->post("tel");
                $model->func = implode(",",$request->post("list"));
                $model->ip= $request->getUserIP();

                if($model->validate() && $model->save()){
                    $return['msg'] = '提交成功！';
                }else{
                    $return['msg'] = current($model->getFirstErrors());
                }
            }catch (\Exception $e){
                $return['msg'] = $e->getMessage();
                $return['success'] = false;
            }
            return $this->asJson($return);
        }






        return $this->renderPartial("index");
    }
}
