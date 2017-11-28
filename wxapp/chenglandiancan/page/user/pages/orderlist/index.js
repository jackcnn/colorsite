var app = getApp();
const orderlist = require('../../../../config').orderlist;


Page({
    data:{
        list: [],
    },
    onLoad:function(params)
    {
        var self = this;
        wx.showLoading();
        app.getUserOpenId(function () {
            wx.request({
                url: orderlist,
                data:{
                    openid:app.globalData.openid
                },
                success: function(res) {
                    wx.hideLoading();
                    if(res.data.list){
                        self.setData({
                            list:res.data.list,
                        });
                    }
                }
            });
        });

    },

})