<?php
/**
 * Date: 2017/9/26 0026
 * Time: 15:06
 */
namespace frontend\controllers;

use common\models\Images;
use frontend\controllers\BaseController;
use yii\data\Pagination;

use common\models\Gallery;

class GalleryController extends BaseController
{
    public $layout = "gallerys";

    public function actionIndex($token)
    {
        $query = Gallery::find()->where(['isopen'=>1,'token'=>$token]);

        $count = $query->count();

        $pagination = new Pagination([
            'totalCount'=>$count,
            'defaultPageSize'=>20
        ]);

        $gallerys = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy("sort,id DESC")
            ->asArray()->all();

        return $this->render('index',[
            'gallerys'=>$gallerys,
            'pagination'=>$pagination
        ]);
    }

    public function actionDetail($token,$id)
    {
        $data['now'] = Gallery::findOne(['id'=>$id,'token'=>$token]);

        $data['next'] = Gallery::find()->where(['token'=>$token])
            ->andWhere(['>','id',intval($id)])
            ->orderBy("sort,id DESC")->one();

        $data['prev'] = Gallery::find()->where(['token'=>$token])
            ->andWhere(['<','id',intval($id)])
            ->orderBy("sort,id DESC")->one();

        $list = Images::find()->where(['token'=>$token,'markid'=>$id,'table'=>'gallery'])
            ->orderBy("sort,id DESC")
            ->asArray()->all();

        return $this->render('detail',[
            'data'=>$data,
            'list'=>$list
        ]);

    }

}
