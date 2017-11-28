var app = getApp();
const payorder = require('../../../../config').payorder;
const orderdetail = require('../../../../config').orderdetail;

Page({
    data:{
        list: [],
        params:{},
        order:[],
        storeName:'',
    },
    onLoad:function(params)
    {
        var self = this;
        wx.showLoading();
        wx.request({
            url: orderdetail,
            data:{
                sid:params.sid,
                tid:params.tid,
                orderid:params.orderid,
                ordersn:params.ordersn
            },
            success: function(res) {
                wx.hideLoading();
                if(res.data.success){
                    self.setData({
                        order:res.data.order,
                        list:res.data.order.list,
                        params:params,
                        storeName:res.data.store.name
                    })
                }else{

                }
            }
        });

    },

})