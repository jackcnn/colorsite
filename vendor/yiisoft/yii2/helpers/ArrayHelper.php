<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\helpers;

/**
 * ArrayHelper provides additional array functionality that you can use in your
 * application.
 *
 * For more details and usage information on ArrayHelper, see the [guide article on array helpers](guide:helper-array).
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ArrayHelper extends BaseArrayHelper
{
    /*
     * 树结构
     * */
    public static function createTree($array,$parentid=0,$id='id',$pid='pid',$level=1,$plist=array(),$child='children'){
        $n=1;
        $result = array();
        foreach($array as $key => $val){
            if($val[$pid] == $parentid) {
                $tmp = $array[$key];
                $tmp['level']=$level;
                $tmp['plist']=$plist;
                $nplist=array_merge($plist,array($val[$id]));
                unset($array[$key]);
                $tmp[$child] = self::createTree($array,$val[$id],$id,$pid,$level+1,$nplist);
                $result[$key] = $tmp;
            }
        }

        return $result;
    }

    /*
     * 树结构变回一维数组
     * */

    public static function treeTosingle($array,$child='children'){
        static $result_array=array();
        foreach($array as $key=>$value){
            $result_array[]=$value;
            if(is_array($value[$child])){
                self::treeTosingle($value[$child]);
            }
        }
        return $result_array;
    }

    /*
     * 拿通过createTree生成的树结构某ID的plist
     * */

    public static function treeGetplist($array,$id,$child='children'){
        $data=self::treeTosingle($array);
        foreach($data as $item){
            if($item['id']==$id){
                return $item['plist'];
            }
        }
    }

    /*
     * 对象转数组,使用get_object_vars返回对象属性组成的数组
     * */
    public static function objectToArray($obj)
    {
        $arr = is_object($obj) ? get_object_vars($obj) : $obj;
        if(is_array($arr)){
            return array_map(__METHOD__, $arr);
        }else{
            return $arr;
        }
    }

    /*
     * 数组转对象
     * */
    public static function arrayToObject($arr)
    {
        if(is_array($arr)){
            return (object) array_map(__METHOD__, $arr);
        }else{
            return $arr;
        }
    }

    public static function arrayToXml($data)
    {
        if(!is_array($data) || count($data) <= 0)
        {
            throw new \Exception('数据错误');
        }

        $xml = "<xml>";
        foreach ($data as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    public static function xmlToArray($xml)
    {
        $array = (array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        return $array;
    }
}
