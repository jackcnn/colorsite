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

    public function actionIndex($page=1)
    {
        $size = 12;
        $data= (new \yii\db\Query())
            ->from('ms_gallery')
            ->orderBy("id asc")
            ->offset(($page-1)*$size)
            ->limit($size)
            ->all();

        $count = (new \yii\db\Query())
            ->from('ms_gallery')->count();
        $total = ceil($count/$size);

        $list = array_chunk($data,4);

        $pager['cur'] = $page;
        $pager['count'] = $count;
        $pager['total'] = $total;

        if($page > $total-5 ){
            $pager['start'] = $total - 10;
            $pager['end'] = $total;
        }elseif($page > 5){
            $pager['start'] = $page-5;
            $pager['end'] = $page +5;
        }else{
            $pager['start'] = 1;
            $pager['end'] = 10;
        }




        return $this->renderPartial("index",[
            'list'=>$list,
            'pager'=>$pager
        ]);
    }

    public function actionDetail($id)
    {
        $data = (new \yii\db\Query())
            ->from('ms_gallery')
            ->where(['id'=>$id])
            ->one();

        $prev =(new \yii\db\Query())
            ->from('ms_gallery')
            ->where(['<','id',$id])
            ->orderBy("id desc")
            ->limit(1)
            ->one();

        $next =(new \yii\db\Query())
            ->from('ms_gallery')
            ->where(['>','id',$id])
            ->limit(1)
            ->one();
        if($prev){
            $prev_data['title'] = "上一页：".$prev['title'];
            $prev_data['router'] = Url::to(['/site/detail','id'=>$prev['id']]);
        }else{
            $prev_data['title'] = "上一页：没有了";
            $prev_data['router'] ="javascript:;";
        }

        if($next){
            $next_data['title'] = "下一页：".$next['title'];
            $next_data['router'] = Url::to(['/site/detail','id'=>$next['id']]);
        }else{
            $next_data['title'] = "下一页：没有了";
            $next_data['router'] ="javascript:;";
        }

        return $this->renderPartial("detail",[
            'data'=>$data,
            'list'=>json_decode($data['imgs'],1),
            'prev'=>$prev_data,
            'next'=>$next_data
        ]);
    }


    public function actionImg($url){
        header('Content-type: image/jpeg');
        echo file_get_contents(isset($url)?$url:'');
    }


    public function actionForm()
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
