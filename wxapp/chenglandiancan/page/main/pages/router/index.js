var app = getApp();
const router = require('../../../../config').router;
Page({
    data:{
    },
    onLoad:function(params)
    {
        var self = this;
        wx.request({
            url:router,
            data: {
                sid:params.sid,
                tid:params.tid
            },
            success: function(res) {

                if(res.role == "clerk"){
                    var path = "/page/";
                }else{
                    var path = "";
                }

                wx.reLaunch({
                    url: path
                });

            }
        });
    }

})