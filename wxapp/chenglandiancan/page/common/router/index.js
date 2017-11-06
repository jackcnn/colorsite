var app = getApp();
const router = require('../../../config').router;
Page({
    data:{
    },
    onLoad:function(params)
    {
        wx.showLoading('请稍后...');
        var self = this;
        if(params.sid && params.tid){
            app.getUserOpenId(function(){
                wx.request({
                    url:router,
                    data: {
                        sid:params.sid,
                        tid:params.tid,
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