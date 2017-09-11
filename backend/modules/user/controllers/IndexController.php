<?php
/**
 * Date: 2017/9/11 0011
 * Time: 10:46
 */

namespace backend\modules\user\controllers;

use common\models\User;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\helpers\ColorHelper;
class IndexController extends Controller
{
    public function actionIndex()
    {
        $request = \Yii::$app->request;
        $model = User::findOne(['id'=>\Yii::$app->user->getId()]);
        if($request->isPost){
            $model->load($request->post());
            $model->avatar = FileHelper::upload($model,'avatar');
            if($model->validate() && $model->save()){
                \Yii::$app->session->setFlash('AlertMsg','用户信息保存成功');
                return $this->redirect(['/site/index']);
            }else{
                \Yii::$app->session->setFlash('ErrMsg','用户信息保存失败'.current($model->getFirstErrors()));
            }
        }
        return $this->render('index',[
            'model'=>$model
        ]);
    }
}