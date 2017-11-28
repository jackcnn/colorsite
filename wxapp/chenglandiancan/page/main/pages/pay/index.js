var app = getApp();
const payorder = require('../../../../config').payorder;
const orderdetail = require('../../../../config').orderdetail;

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
                        list:res.data.order.list,
                        true_price:res.data.order.amount/100,
                        params:params,
                        table:res.data.table
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
        wx.showLoading();
        app.getUserOpenId(function(){
            wx.getUserInfo({
                success: function(res) {
                    var userInfo = res.userInfo
                    var nickName = userInfo.nickName

                    wx.request({
                        url: payorder,
                        data:{
                            orderid:params.orderid,
                            ordersn:params.ordersn,
                            openid:app.globalData.openid,
                            wxname:encodeURI(nickName),
                        },
                        success: function(res) {
                            wx.hideLoading();
                            if(res.data.success){
                                //调起微信支付JSAPI
                                self.callwxpay(res.data.jsapiparams,function () {
                                    wx.showModal({
                                        content: '支付成功！',
                                        confirmColor:'#20a0ff',
                                        showCancel:false,
                                        success: function(res) {
                                            wx.redirectTo({
                                                url: "/page/user/pages/order/index?sid="+params.sid+"&tid="+params.tid+"&orderid="+self.data.params.orderid+"&ordersn="+self.data.params.ordersn
                                            });
                                        }
                                    });
                                });
                            }else{
                                wx.showModal({
                                    content: '订单提交失败！！',
                                    confirmColor:'#20a0ff',
                                    showCancel:false,
                                    success: function(res) {
                                    }
                                });
                            }
                        }
                    });


                }
            })

        });


    },
    callwxpay:function(data,callback){

        wx.requestPayment({
            'timeStamp': data.timeStamp,
            'nonceStr': data.nonceStr,
            'package': data.package,
            'signType': data.signType,
            'paySign': data.paySign,
            'success':function(res){
                if(res.errMsg == "requestPayment:ok" ) {// 支付成功后的回调函数
                    if(callback){
                        callback();
                    }
                }else{
                    wx.showModal({
                        content: '支付失败！',
                        confirmColor:'#20a0ff',
                        showCancel:false,
                        success: function(res) {
                        }
                    });
                }
            },
            'fail':function(res){
                wx.showModal({
                    content: '支付失败！！',
                    confirmColor:'#20a0ff',
                    showCancel:false,
                    success: function(res) {
                    }
                });
            }
        })


    }
})