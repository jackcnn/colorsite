<?php
namespace backend\controllers;

use common\models\User;
use Yii;
use backend\controllers\BaseController;
use yii\db\Exception;
use yii\helpers\ColorHelper;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    public function actionIndex()
    {

        return $this->render('index');
    }
    //登录页面
    public function actionLogin()
    {
        $this->layout = 'page';
        $model = new User();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post('User');
            try{
                $user=$model::findOne(['username'=>$post['username']]);
                if(!$user){
                    throw new \Exception('邮箱不存在！');
                }
                if($user->is_active<1){
                    throw new \Exception('账号未激活！');
                }
                if(!\Yii::$app->security->validatePassword($post['password'],$user->password)){
                    throw new \Exception('密码错误！');
                }
                $identity = \backend\models\UserAccess::findIdentity($user->id);
                if(isset($post['token']) && current($post['token'])){
                    if($user->parent_id<1){
                        $cookie_time=3600*24*7;
                    }else{
                        $cookie_time=3600*5;
                    }
                }else{
                    $cookie_time = 0;
                }
                if(\Yii::$app->user->login($identity,$cookie_time)){
                    \Yii::info('登录成功'.$user->id.'-ip'.\Yii::$app->request->userIP,__METHOD__);
                    //用户登录,cookie7天有效,子帐号则为5个小时
                    return $this->redirect(['/site/index']);
                }else{
                    throw new \Exception('登录失败！');
                }
            }catch (\Exception $e){
                \Yii::$app->session->setFlash("RegisterMsg",$e->getMessage());
                $model->username = $post['username'];
            }
        }
        return $this->render('login',[
            'model'=>$model
        ]);
    }
    //注册页面
    public function actionRegister()
    {
        $this->layout = 'page';
        $model = new User();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post('User');

            try{
                $count=$model::find()->where(['username'=>$post['username']])->count();
                if($count>0){
                    throw new \Exception('邮箱已注册！');
                }
                if($post['password'] != $post['token']){
                    throw new \Exception('两次密码输入不一致！');
                }
                if(strlen($post['password'])<6){
                    throw new \Exception('密码长度最少6位');
                }
                $model->parent_id=0;
                $model->token = md5($post['username']);
                $model->is_admin =0;
                $model->username = $post['username'];
                $model->password = \Yii::$app->security->generatePasswordHash($post['password']);
                $model->nickname = $post['nickname'];
                $model->avatar = '';
                $model->auth_key=\Yii::$app->security->generateRandomString();
                $model->access_token=\Yii::$app->security->generateRandomString();
                $model->expire=(string)(time()+3600*24);
                $model->is_active=0;
                if($model->validate() && $model->save()){
                    $active_link=\yii\helpers\Url::toRoute(['site/active','email'=>$model->username,'token'=>md5($model->access_token)],true);
                    $sendcontent='感谢您注册colorsite管理系统，请点击链接确认您的认证邮箱。（如果邮箱内无法点击链接，请直接复制链接到浏览器打开）<br/><a href="'.$active_link.'">'.$active_link.'</a>';
                    $mail= \Yii::$app->mailer->compose();
                    $mail->setTo($model->username);
                    $mail->setSubject("colorsite注册邮箱认证");
                    $mail->setHtmlBody($sendcontent);
                    $mail->send();
                    \Yii::$app->session->setFlash("RegisterMsg","我们已发送认证邮件到您的邮箱，请及时查看");
                    return $this->redirect(['site/login']);
                }
            }catch (\Exception $e){
                $model->username = $post['username'];
                $model->nickname = $post['nickname'];
                \Yii::$app->session->setFlash("RegisterMsg",$e->getMessage());
            }
        }
        return $this->render('register',[
            'model'=>$model
        ]);
    }
    public function actionActive($email,$token)
    {
        $model = User::findOne(['username'=>$email]);
        try{
            if(!$model){
                throw new \Exception('邮箱未注册');
            }
            if($token != md5($model->access_token)){
                throw new \Exception('token不正确');
            }
            if($model->is_active == 1){
                throw new \Exception('邮箱已激活');
            }
            $model->is_active = 1;
            if($model->save()){
                \Yii::$app->session->setFlash("RegisterMsg","邮箱认证成功！请登录");
                return $this->redirect(['site/login']);
            }else{
                throw new \Exception(current($model->getFirstError()));
            }
        }catch (\Exception $e){
            \Yii::$app->session->setFlash("RegisterMsg",$e->getMessage());
            return $this->redirect(['site/login']);
        }
    }
    /*
     * 退出登录
     * */
    public function actionLogout()
    {
        if(\Yii::$app->user->logout()){
            return $this->redirect(['/site/index']);
        }else{
            die('退出登陆失败');
        }
    }
}
