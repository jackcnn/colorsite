<?php
namespace backend\controllers;

use backend\models\UserAccess;
use common\models\User;
use Faker\Provider\Color;
use Yii;
use backend\controllers\BaseController;
use yii\db\Exception;
use yii\helpers\ColorHelper;
use yii\helpers\FileHelper;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    //后台iframe框架页
    public function actionIndex()
    {
        $this->layout = 'site';
        if (class_exists('\yii\debug\Module')) {//不显示debugToolbar
            Yii::$app->view->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
        }
        return $this->render('index');
    }
    //后台首页--展示一些信息
    public function actionHome()
    {
        return $this->render('home');
    }
    //登录页面
    public function actionLogin()
    {
        $this->layout = 'page';

        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post('User');
            try{
                $user=UserAccess::findOne(['username'=>$post['username']]);
                if(!$user){
                    throw new \Exception('邮箱不存在！');
                }
                if($user->is_active<1){
                    throw new \Exception('账号未激活！');
                }
                if(!\Yii::$app->getSecurity()->validatePassword($post['password'],$user->password)){
                    throw new \Exception('密码错误！');
                }
                //更新token
                if(!$user->token){
                    $user->token = ColorHelper::id2token($user->id);
                    $user->save();
                }
                $identity = UserAccess::findIdentity($user->id);
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
                    ColorHelper::log('登录');
                    return $this->redirect(['/site/index']);
                }else{
                    throw new \Exception('登录失败！');
                }
            }catch (\Exception $e){
                \Yii::$app->session->setFlash("RegisterMsg",$e->getMessage());
                $model = new User();
                $model->username = $post['username'];
            }
        }else{
            $model = new User();
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
                $model->token = "";
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
                }else{
                    \Yii::$app->session->setFlash("RegisterMsg",current($model->getFirstErrors()));
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


    //忘记密码页面
    public function actionForgetPwd()
    {
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post('User');

            $email = $post['username'];
            $model = User::find()->where(['username'=>$email])->one();
            if(!$model){
                \Yii::$app->session->setFlash("RegisterMsg","邮箱未注册！");
                return $this->redirect(['site/login']);
            }

            \Yii::$app->cache->set(md5($email),$email,3600);

            $active_link=\yii\helpers\Url::toRoute(['site/repwd','email'=>$model->username,'token'=>md5($model->access_token)],true);
            $sendcontent='你的账号：'.$email.'正在申请重置密码，点击链接进入重置密码页面，1小时内有效（如果邮箱内无法点击链接，请直接复制链接到浏览器打开）<br/><a href="'.$active_link.'">'.$active_link.'</a>';
            $mail= \Yii::$app->mailer->compose();
            $mail->setTo($model->username);
            $mail->setSubject("colorsite重置密码");
            $mail->setHtmlBody($sendcontent);
            $mail->send();
            \Yii::$app->session->setFlash("RegisterMsg","我们已发送认证邮件到您的邮箱，请及时查看");
            return $this->redirect(['site/login']);
        }else{
            $model = new User();
        }
        return $this->render('forget-pwd',[
            'model'=>$model
        ]);
    }

    //修改密码
    public function actionRepwd($email,$token)
    {

        try{
            $model = User::findOne(['username'=>$email]);
            if(!$model){
                throw new \Exception('邮箱未注册');
            }
            if($token != md5($model->access_token)){
                throw new \Exception('token不正确');
            }

            if(!\Yii::$app->cache->get(md5($email))){
                throw new \Exception('链接已过期，请重新操作！');
            }

            if(\Yii::$app->request->isPost){

                $post = \Yii::$app->request->post('User');

                if($post['password'] != $post['token']){
                    \Yii::$app->session->setFlash("RegisterMsg",'两次密码不一致');
                    return $this->redirect(\Yii::$app->request->absoluteUrl);
                }


                $model->password = \Yii::$app->security->generatePasswordHash($post['password']);

                if($model->save()){
                    \Yii::$app->session->setFlash("RegisterMsg","密码修改成功！请登录");
                    return $this->redirect(['site/login']);
                }else{
                    throw new \Exception(current($model->getFirstError()));
                }
            }


        }catch (\Exception $e){
            \Yii::$app->session->setFlash("RegisterMsg",$e->getMessage());
            return $this->redirect(['site/login']);
        }

        return $this->render('repwd',[
            'model'=>$model
        ]);

    }


    //邮箱激活页面
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
            return $this->redirect(['/site/login']);
        }else{
            die('退出登陆失败');
        }
    }

    /*
     * 网站基本信息配置
     * */
    public function actionConfig()
    {
        $site_model = new \common\models\Site();
        $model = $site_model::findOne(['ownerid'=>$this->ownerid,'token'=>$this->token]);
        if(!$model){
            $site_model->ownerid = $this->ownerid;
            $site_model->token = $this->token;
            $site_model->save();
            $model = $site_model::findOne(['ownerid'=>$this->ownerid,'token'=>$this->token]);
        }
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->logo = FileHelper::upload($model,'logo');
            if($model->validate() && $model->save()){
                ColorHelper::alert('保存成功！');
            }else{
                ColorHelper::err(current($model->getFirstErrors()));
            }
        }
        return $this->render('config',[
            'model'=>$model
        ]);
    }
}
