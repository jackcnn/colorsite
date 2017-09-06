<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\helpers;

/**
 * File system helper
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Alex Makarov <sam@rmcreative.ru>
 * @since 2.0
 */
class FileHelper extends BaseFileHelper
{
    /*
    * 根据文件路径返回文件名
    * @parame $path 文件路径
    * @parame $extenstion 是否返回扩展名
    * */
    public static function filename($path,$extenstion=true)
    {
        $path=self::normalizePath($path);
        $filename=basename($path);
        if(!$extenstion){
            $nameArray=explode(".",$filename);
            $extenstion=end($nameArray);
            $filename=str_replace(".".$extenstion,'',$filename);
        }
        return $filename;
    }

    /*
     * 根据文件路径返回文件目录
     * */
    public static function dirname($path)
    {
        $path=self::normalizePath($path);
        return dirname($path);
    }

    /*
     * 根据数据生成文件
     * */
    public static function datatofile($filename,$data,$ext='jpg'){
        $filepath=self::createpath($filename);
        return file_put_contents($filepath['abs'],$data)?$filepath['path']:false;
    }

    /*
     * 根据html5 datatourl的base64生成图片
     * $filename 可以为空，主要是标记一下
     * */
    public static function base64tofile($filename,$data,$box='',$ext='jpg')
    {
        $data = substr($data,strpos($data,",") + 1);
        $data = base64_decode($data);
        $filepath=self::createpath($filename);
        if(is_array($box)){
            $size=file_put_contents($filepath['abs'],$data);
            \yii\imagine\Image::thumbnail($filepath['abs'],$box[0],$box[1])->save($filepath['abs']);
            return $size?$filepath['path']:false;
        }else{
            return file_put_contents($filepath['abs'],$data)?$filepath['path']:false;
        }
    }


    /*
     * 生成一个上传路径
     * */
    public static function createpath($dir='common',$filename='',$type='month')
    {
        switch ($type){
            case 'year':
                $sdir=date('Y');break;
            case 'month':
                $sdir=date('Ym');break;
            case 'day':
                $sdir=date('Ymd');break;
        }
        $saveDir = \Yii::getAlias('@site') .'/uploads/'. $dir .'/'. $sdir;
        $returnDir = '/uploads/'. $dir .'/'. $sdir;
        if(!is_dir($saveDir)){
            self::createDirectory($saveDir);
        }
        if($filename){
            $tmp = explode(".",$filename);
            $ext = end($tmp);
            $final = md5(time().uniqid().$filename);
            $return['path']= $returnDir.'/'.$final.'.'.$ext;
            $return['abs']= $saveDir.'/'.$final.'.'.$ext;
        }else{
            $return['path']= $returnDir;
            $return['abs']= $saveDir;
        }
        return $return;
    }

    /*
     * 文件上传
     * $model 为字符串的时候直接用那个名字
     * */
    public static function upload($model,$attribue='',$size=1)
    {
        if($model instanceof \yii\db\ActiveRecord){
            $name = \yii\helpers\Html::getInputName($model,$attribue);
            $orignal_value = \yii\helpers\Html::getAttributeValue($model,$attribue);
        }else{
            $name = $model;
            $orignal_value = '';
        }
        $file = \yii\web\UploadedFile::getInstanceByName($name);

        if(!$file){
            return $orignal_value;
        }

        if($file->size>1024*1024*$size){
            throw new Exception('上传文件不得大于1M');
        }
        $allow_ext=array('jpg', 'jpeg', 'png','gif');
        if (!in_array($file->getExtension(),$allow_ext)) {
            throw new Exception('只能上传'.implode(",",$allow_ext).'格式的图片');
        }else{
            if (!\Yii::$app->user->getId()) {
                $dirNo = "common";
            } else {
                $dirNo = sprintf("%05d", \Yii::$app->user->getId());
            }
            $path = self::createpath($dirNo,$file->getBaseName().'.'.$file->getExtension());
            $file->saveAs($path['abs']);
            return $path['path'];
        }
    }

}