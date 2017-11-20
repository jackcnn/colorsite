/**
 * 小程序配置文件
 */

// 此处主机域名是腾讯云解决方案分配的域名
// 小程序后台服务解决方案：https://www.qcloud.com/solution/la

var host = "https://326108993.com";
//     var host = "http://colorsite.com";
var config = {
    host,
    //登陆
    openIdUrl: `${host}/dish/index/login.html`,
    //商户列表
    mchlist: `${host}/dish/index/mch-list.html`,
    // 获取菜单
    getdishes: `${host}/dish/index/getdishes.html`,
    // 提交购物车
    submit_cart: `${host}/dish/index/submit-cart.html`,
    //电源查看页面
    show_cart: `${host}/dish/index/show-cart.html`,
    //打印订单
    print_cart: `${host}/dish/index/print_cart.html`,
    //绑定页面
    bindclerk: `${host}/dish/index/bind-clerk.html`,
    //判断跳转
    router: `${host}/dish/index/router.html`,
    //店员提交打印页面
    clerk_submit_cart: `${host}/dish/index/clerk-subcart.html`,
    //提交订单页面
    createorder: `${host}/dish/index/create-order.html`,
    //微信支付页面
    payorder: `${host}/dish/index/pay-order.html`,
    //订单列表
    orderlist: `${host}/dish/index/order-list.html`,
    //订单详细
    orderdetail: `${host}/dish/index/order-detail.html`,
    //付款马上打单
    submit_order: `${host}/dish/index/submit-order.html`,
    //笑话
    jokelist: `${host}/dish/index/joke-list.html`,

};

module.exports = config
