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

    public static $adzone_id="147956443";



    public static function getlist($favorites_id,$page=1)
    {
        include "TopSdk.php";
        //选品库id ，14072980

        $c = new \TopClient;
        $c->appkey = self::$appkey;
        $c->secretKey = self::$secret;
        $req = new \TbkUatmFavoritesItemGetRequest;
        $req->setPlatform("2");
        $req->setPageSize("20");
        $req->setAdzoneId(self::$adzone_id);
        $req->setUnid(time());
        $req->setFavoritesId($favorites_id);
        $req->setPageNo($page);
        $labels=[
            "num_iid","title","pict_url","small_images","reserve_price","zk_final_price","user_type","provcity","item_url","click_url","nick","seller_id",
            "volume","tk_rate","zk_final_price_wap",
            "shop_title","event_start_time","event_end_time","type","status","category","coupon_click_url","coupon_end_time","coupon_info",
            "coupon_start_time","coupon_total_count","coupon_remain_count"
        ];
        $req->setFields(implode(",",$labels));
        $resp = $c->execute($req);
        return $resp;

    }

    public static function getcategory()
    {

        include "TopSdk.php";

        $c = new \TopClient;
        $c->appkey = self::$appkey;
        $c->secretKey = self::$secret;
        $req = new \TbkUatmFavoritesGetRequest;
        $req->setPageNo("1");
        $req->setPageSize("100");
        $req->setFields("favorites_title,favorites_id,type");
        $req->setType("-1");
        $resp = $c->execute($req);

        return $resp;
    }


    public static function getlist111()
    {

        include "TopSdk.php";

        $c = new \TopClient;
        $c->appkey = self::$appkey;
        $c->secretKey = self::$secret;
        $req = new \TbkItemGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
        $req->setQ("女装尖货");
//        $req->setCat("16,18");
//        $req->setItemloc("杭州");
//        $req->setSort("tk_rate_des");
//        $req->setIsTmall("false");
//        $req->setIsOverseas("false");
//        $req->setStartPrice("10");
//        $req->setEndPrice("10");
//        $req->setStartTkRate("123");
//        $req->setEndTkRate("123");
        $req->setPlatform("1");
//        $req->setPageNo("123");
//        $req->setPageSize("20");
        $resp = $c->execute($req);
        return $resp;

    }

    public static function taokoulin()
    {
        include "TopSdk.php";
        $c = new \TopClient;
        $c->appkey = self::$appkey;
        $c->secretKey = self::$secret;
        $req = new \TbkTpwdCreateRequest;
        $req->setUserId("124102488");
        $req->setText("有汇聚的优惠来啦");
        $req->setUrl("https://item.taobao.com/item.htm?id=560240344400");
//        $req->setLogo("https://326108993.com/uploads/00001/201710/ec767bd83519bb1204f951a1c03256b5.jpg");
        $resp = $c->execute($req);
        return $resp;
    }






}