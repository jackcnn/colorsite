var app = getApp();
const show_cart = require('../../../../config').show_cart;

Page({
    data:{
        list: [],
        params:{},
        total_price:0,
        true_price:0,
        table:''
    },
    onLoad:function(params)
    {
        var self = this;
        wx.showLoading();
        wx.request({
            url: show_cart,
            data:{
                sid:params.sid,
                tid:params.tid
            },
            success: function(res) {
                wx.hideLoading();
                var store = res.data.store;
                var category = res.data.category;
                var total_count = res.data.total_count;
                var total_price = res.data.total;
                var table = res.data.table;

                wx.setNavigationBarTitle({
                    title: store.name
                });

                self.setData({
                    category:category,
                    total_count:total_count,
                    total_price:total_price/100,
                    params:params,
                    table:table
                });
            }
        });

    },
    add:function () {
        wx.showModal({
            content:'请呼叫服务员加菜',
            confirmColor:'#20a0ff',
            showCancel:false,
        });
    }
})