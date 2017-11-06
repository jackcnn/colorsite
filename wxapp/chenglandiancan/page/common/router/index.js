var app = getApp();
const router = require('../../../config').router;
Page({
    data:{
    },
    onLoad:function(params)
    {
        wx.showLoading('请稍后...');
        var self = this;
        wx.request({
            url:router,
            data: {
                sid:params.sid,
                tid:params.tid
            },
            success: function(res) {
                var path = res.data.path;
                wx.reLaunch({
                    url: path
                });

            }
        });
    }

})