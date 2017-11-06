var app = getApp();
const orderlist = require('../../../../config').orderlist;


Page({
    data:{
        list: [],
    },
    onLoad:function(params)
    {
        var self = this;

        app.getUserOpenId(function () {
            wx.request({
                url: orderlist,
                data:{
                    openid:app.globalData.openid
                },
                success: function(res) {
                    if(res.data.success){
                        self.setData({
                            order:res.data.list,
                        });
                    }
                }
            });
        });

    },

})