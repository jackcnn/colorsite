/**
 * 小程序配置文件
 */


var host = "https://326108993.com";
//     var host = "http://colorsite.com";
var config = {
    host,
    //登陆
    openIdUrl: `${host}/tbk/index/login.html`,
    // 第一次获取菜单和列表
    getIndex: `${host}/tbk/index/index.html`,
    //获取列表
    getLists: `${host}/tbk/index/lists.html`,

};

module.exports = config
