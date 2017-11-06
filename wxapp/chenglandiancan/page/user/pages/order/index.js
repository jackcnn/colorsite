var app = getApp();
const payorder = require('../../../../config').payorder;
const orderdetail = require('../../../../config').orderdetail;

Page({
    data:{
        list: [],
        params:{},
        order:[],
    },
    onLoad:function(params)
    {
        var self = this;

        wx.request({
            url: orderdetail,
            data:{
                orderid:params.orderid,
                ordersn:params.ordersn
            },
            success: function(res) {
                if(res.data.success){
                    self.setData({
                        order:res.data.order,
                        list:res.data.order.list,
                        params:params
                    })
                }else{

                }
            }
        });

    },

})