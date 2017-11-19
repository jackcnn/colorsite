/**
 * 小程序配置文件
 */


var host = "https://326108993.com";
    // var host = "http://colorsite.com";
var config = {
    host,
    //登陆
    openIdUrl: `${host}/index/login.html`,
    // 获取翻译结果
    getIndex: `${host}/index/index.html`,
    //提交信息
    submit: `${host}/index/submit.html`,
};

module.exports = config
