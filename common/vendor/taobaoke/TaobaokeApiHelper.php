<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/10 0010
 * Time: 19:26
 */
namespace common\vendor\taobaoke;


class TaobaokeApiHelper
{

    public static $appkey="24688190";
    Public static $secret="c6d11887d7d35768833ddc55c2a9e8e7";

    public static function getlist()
    {

        include "TopSdk.php";

        $c = new \TopClient;
        $c->appkey = self::$appkey;
        $c->secretKey = self::$secret;
        $req = new \TbkItemGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
        $req->setQ("女装");
        $req->setCat("16,18");
//        $req->setItemloc("杭州");
//        $req->setSort("tk_rate_des");
//        $req->setIsTmall("false");
//        $req->setIsOverseas("false");
//        $req->setStartPrice("10");
//        $req->setEndPrice("10");
//        $req->setStartTkRate("123");
//        $req->setEndTkRate("123");
//        $req->setPlatform("1");
//        $req->setPageNo("123");
//        $req->setPageSize("20");
        $resp = $c->execute($req);
        return $resp;

    }






}