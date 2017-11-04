/**
 * 小程序配置文件
 */

// 此处主机域名是腾讯云解决方案分配的域名
// 小程序后台服务解决方案：https://www.qcloud.com/solution/la

var host = "https://326108993.com"

var config = {

    host,

    // 获取菜单
    getdishes: `${host}/dish/index/getdishes.html`,

    // 提交购物车
    submit_cart: `${host}/dish/index/submit-cart.html`,


};

module.exports = config
