<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/8/13
 * Time: 23:19
 */
namespace frontend\config;

use yii\web\UrlRuleInterface;
use yii\base\Object;

class Route extends Object implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)
    {

        return false;

        foreach($params as $key=>$value){
            $array[]=ucfirst($value);
        }

        return implode($array);
        return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request)
    {

        return false;
        $pathInfo = $request->getPathInfo();

        if(strstr(strtolower($pathInfo),'model')){

            $parame['idd']='999';

            return ['index/em',$parame];
        }

        if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches)) {
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
        }
        return false;  // this rule does not apply
    }
}