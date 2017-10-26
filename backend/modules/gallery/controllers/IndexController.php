<?php

namespace backend\modules\gallery\controllers;

use common\models\Category;
use common\models\Images;
use Yii;
use common\models\Gallery;
use common\models\search\GallerySearch;
use backend\controllers\BaseController;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
class IndexController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new GallerySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'catelist' => $this->getcategories($this->token)
        ]);
    }

    public function actionCreate()
    {
        $model = new Gallery();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->logo = FileHelper::upload($model,'logo');
            $model->ownerid = $this->ownerid;
            $model->token = $this->token;
            $model->time = (string)strtotime($request->post('Gallery')['time']);
            if($model->validate() && $model->save()){
                ColorHelper::alert('新增成功,可以继续添加！');
                \Yii::$app->session->setFlash('gallery_category',$model->cateid);
                return $this->redirect(['create']);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        $model->loadDefaultValues();
        $model->time = time();
        if($cateid=\Yii::$app->session->getFlash('gallery_category')){
            $model->cateid = $cateid;
        }
        return $this->render('create', [
            'model' => $model,
            'list'=>$this->getcategories($this->token)
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->logo = FileHelper::upload($model,'logo');
            $model->ownerid = $this->ownerid;
            $model->token = $this->token;
            $model->time = (string)strtotime($request->post('Gallery')['time']);
            if($model->validate() && $model->save()){
                ColorHelper::alert('修改成功！');
                return $this->redirect(['index']);
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        return $this->render('update', [
            'model' => $model,
            'list'=>$this->getcategories($this->token)
        ]);
    }

    public function actionGallery($id)
    {
        $model = $this->findModel($id);
        $list = Images::find()->where(['markid'=>$id,'table'=>'gallery'])->orderBy('sort asc,id desc')->asArray()->all();
        return $this->render('gallery',[
            'model'=>$model,
            'list' =>$list
        ]);
    }

    public function actionDeleteImage($id)
    {
        $model = Images::findOne(['id'=>$id]);
        FileHelper::unlink($model->path);
        $model->delete();
        return $this->asJson(['success'=>true]);
    }
    public function actionImageName($id,$name)
    {
        $model = Images::findOne(['id'=>$id]);
        $model->name = urldecode($name);
        $model->save();
        return $this->asJson(['success'=>true]);
    }

    public function actionUpload($gallery_id,$width=0,$height=0)
    {
        $path = FileHelper::upload('file','',[$width,$height],true,10);
        $model = new Images();
        $model->name = $path['name'];
        $model->path = $path['path'];
        $model->table = 'gallery';
        $model->markid = $gallery_id;
        $model->token = $this->token;
        $model->sort = 0;
        if($model->validate() && $model->save()){
            $path['id'] = $model->id;
            $data['code']=0;
            $data['msg']='上传成功';
            $data['data']=$path;
        }else{
            $data['code'] = -1;
            $data['msg'] = current($model->getFirstErrors());
            $data['data'] = [];
            FileHelper::unlink($path['path']);
        }
        return $this->asJson($data);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        FileHelper::unlink($model->logo);
        $model->delete();
        return $this->redirect(['index']);
    }

    protected function getcategories($token)
    {
        $category_list = Category::find()->where(['table'=>'gallery','token'=>$token])->asArray()->all();
        $list=[];
        foreach($category_list as $key=>$value){
            $list[$value['id']]=$value['name'];
        }
        return $list;
    }

    protected function findModel($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTaobao($id)
    {

        $model = $this->findModel($id);

        $list = Images::find()->where(['markid'=>$id,'table'=>'gallery'])->asArray()->all();


        return $this->render("taobao",[
            'model'=>$model,
            'list'=>$list
        ]);
    }

}
