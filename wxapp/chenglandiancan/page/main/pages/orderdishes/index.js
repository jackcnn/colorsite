var app = getApp();
const show_cart = require('../../../../config').show_cart;

Page({
    data:{
        list: [],
        params:{},
        total_price:0,
        true_price:0,
    },
    onLoad:function(params)
    {
        var self = this;

        wx.request({
            url: show_cart,
            data:{
                sid:params.sid,
                tid:params.tid
            },
            success: function(res) {
                var store = res.data.store;
                var category = res.data.category;
                var total_count = res.data.total_count;
                var total_price = res.data.total;

                wx.setNavigationBarTitle({
                    title: store.name
                });

                self.setData({
                    category:category,
                    total_count:total_count,
                    total_price:total_price/100,
                    params:params
                });
            }
        });

    },
    add:function () {
        wx.showModal({
            content:'呼叫服务员加菜'
        });
    }
})