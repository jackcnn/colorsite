var app = getApp();
const show_cart = require('../../../../config').show_cart;

Page({
    data:{
        cartlist: [],
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
                console.log(res)
            }
        });

    },
    onReady:function(){
        var self = this;
    },
    submit:function () {

    }

})