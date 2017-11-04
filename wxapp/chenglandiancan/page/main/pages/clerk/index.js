var app = getApp();
const show_cart = require('../../../../config').show_cart;

Page({
    data:{
        cartlist: [],
        total:0,
        params:{},
    },
    onLoad:function(params)
    {
        var self = this;
        wx.request({
            url: show_cart,
            data: {
                sid:params.sid,
                tid:params.tid,
                openid:app.globalData.openid
            },
            success: function(res) {
                self.setData({
                    'cartlist':res.data.cartlist,
                    'total':res.data.total/100
                });
            }
        });
    },
    onReady:function(){
        var self = this;
    },
    submit:function () {

    }

})