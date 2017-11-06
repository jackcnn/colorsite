var app = getApp();
const payorder = require('../../../../config').payorder;
const orderdetail = require('../../../../config').orderdetail;

Page({
    data:{
        params:{},
        hadpay:false,
        order:[],
        paytime:'',
        pay_name:'',
    },
    onLoad:function(params)
    {
        var self = this;
        self.setData({
            params:params
        });
    },
    checkpay:function () {
        var self = this;
        var params = self.data.params;
        wx.showLoading("查询中...")
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
                    var order = res.data.order;
                    if(parseInt(order.status) == 2 && order.paytime >0){
                        self.setData({
                            hadpay:true,
                            paytime:order.format_paytime,
                            pay_name:order.paytype_name
                        });
                    }else{
                        self.setData({
                            hadpay:false,
                            paytime:order.format_paytime,
                            pay_name:order.paytype_name
                        });
                    }
                }
            }
        });
    }


})