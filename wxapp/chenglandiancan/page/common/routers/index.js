var app = getApp();
const router = require('../../../config').router;
Page({
    data:{
    },
    onLoad:function(params)
    {
        var self = this;
        //微信小程序二维码扫描
        var sid = params.sid;
        var tid = params.tid;

        wx.showLoading('请稍后...');
        if(sid && tid){
            app.getUserOpenId(function(){
                wx.request({
                    url:router,
                    data: {
                        sid:sid,
                        tid:tid,
                        openid:app.globalData.openid
                    },
                    success: function(res) {
                        console.log(res.data)
                        var path = res.data.path;
                        wx.reLaunch({
                            url: path
                        });
                    }
                });
            });
        }else{
            wx.reLaunch({
                url: "/page/main/index"
            });
        }
    }

})