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

    public static $adzone_id="147956443";//推广位id

    public static $userId = "124102488";//淘宝卡账户ID

    public static function getlist($favorites_id,$page=1,$platform=2,$pageSize=20)
    {
        include "TopSdk.php";
        //选品库id ，14072980
        $c = new \TopClient;
        $c->appkey = self::$appkey;
        $c->secretKey = self::$secret;
        $req = new \TbkUatmFavoritesItemGetRequest;
        $req->setPlatform($platform);
        $req->setPageSize($pageSize);
        $req->setAdzoneId(self::$adzone_id);
        $req->setUnid(time());
        $req->setFavoritesId((string)$favorites_id);
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



    public static function taokoulin($url,$title='粉丝优惠来啦')
    {
        include "TopSdk.php";
        $c = new \TopClient;
        $c->appkey = self::$appkey;
        $c->secretKey = self::$secret;
        $req = new \TbkTpwdCreateRequest;
        $req->setUserId(self::$userId);
        $req->setText($title);
        $req->setUrl($url);
        $req->setLogo("https://326108993.com/uploads/00001/201710/ec767bd83519bb1204f951a1c03256b5.jpg");
        $resp = $c->execute($req);
        return $resp;
    }






}