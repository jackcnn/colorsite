var app = getApp();
const payorder = require('../../../../config').payorder;
const orderdetail = require('../../../../config').orderdetail;

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
            url: orderdetail,
            data:{
                sid:params.sid,
                tid:params.tid,
                orderid:params.orderid,
                ordersn:params.ordersn
            },
            success: function(res) {

                if(res.data.success){
                    self.setData({
                        list:res.data.order.list,
                        true_price:res.data.order.amount/100,
                        params:params
                    })
                }else{

                }
            }
        });

    },

    pay:function () {
        var self = this;
        wx.showActionSheet({
            itemList: ['微信支付(￥'+self.data.true_price+')'],
            success: function(res) {

                self.wxpayfunc();

            },
            fail: function(res) {
                console.log(res.errMsg)
            }
        })
    },
    wxpayfunc:function () {//微信支付
        var self = this;
        var params = self.data.params;
        wx.request({
            url: payorder,
            data:{
                orderid:params.orderid,
                ordersn:params.ordersn
            },
            success: function(res) {

                wx.showModal({
                    content: '支付成功！',
                    confirmColor:'#20a0ff',
                    showCancel:false,
                    success: function(res) {
                        // wx.reLaunch({
                        //url: "/page/user/pages/order/index?sid="+params.sid+"&tid="+params.tid+"&orderid="+self.data.params.orderid+"&ordersn="+self.data.params.ordersn
                        // });
                        wx.redirectTo({
                            url: "/page/user/pages/order/index?sid="+params.sid+"&tid="+params.tid+"&orderid="+self.data.params.orderid+"&ordersn="+self.data.params.ordersn
                        });
                    }
                })
            }
        });


    }
})