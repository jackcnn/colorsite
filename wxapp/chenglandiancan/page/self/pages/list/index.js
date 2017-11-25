var app = getApp();
const submit_order = require('../../../../config').submit_order;

Page({
    data:{
        list: [],
        category:[],
        total_price:0,
        params:{},
    },
    onLoad:function(params)
    {
        var self = this;
        wx.getStorage({
            key: 'category',
            success: function(res) {
                var category = res.data;
                var total = 0;
                category.forEach(function(value,key){
                    value.dishes.forEach(function (v,k) {
                        if(v.hascount >0){
                            total = parseInt(v.hascount*v.price) + total;
                        }
                    });
                })

                self.setData({
                    category:res.data,
                    total_price:total/100,
                    params:params
                })
            }
        })

    },
    click_label:function (e) {
        var self = this;
        var cid = e.target.dataset.cid;
        var did = e.target.dataset.did;
        var ix = e.target.dataset.ix;

        var category = self.data.category;

        var check_sel = category[cid].dishes[did].label_list[ix].sel;
        if(check_sel > 0){
            category[cid].dishes[did].label_list[ix].sel = 0;
        }else{
            category[cid].dishes[did].label_list[ix].sel = 1;
        }

        self.setData({
            category:category
        })

    },
    submit:function () {
        var self = this;

        var category = self.data.category;

        var res_list = [];

        category.forEach(function(value,key){
            value.dishes.forEach(function (v,k) {
                if(v.hascount >0){
                    var label="";
                    if(v.label_list){
                        v.label_list.forEach(function(vv,kk){
                            if(vv.sel>0){
                                label = label + "," + vv.name;
                            }
                        });
                    }

                    res_list.push({id:v.id,count:v.hascount,name:v.name,price:v.price,lable:label});
                }
            });
        });

        wx.showActionSheet({
            itemList: ['微信支付（￥'+self.data.total_price+'）'],
            success: function(res) {
                wx.showLoading({title: '加载中.'});

                app.getUserOpenId(function () {
                    wx.request({
                        url: submit_order+"?sid="+self.data.params.sid+"&tid="+self.data.params.tid,
                        data: {
                            res_list:res_list,
                            openid:app.globalData.openid
                        },
                        method:"post",
                        success: function(res) {
                            console.log(app.globalData)
                            if(res.data.success){
                                wx.removeStorageSync("cart-list");
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
                                        content: '订单提交失败！',
                                        confirmColor:'#20a0ff',
                                        showCancel:false,
                                        success: function(res) {
                                        }
                                    });
                                }



                            }else{
                                wx.setStorageSync('cart-list', {});
                                wx.setStorage({
                                    key:'alert-flash',
                                    data:{type:'error',msg:'提交失败'},
                                    success:function () {
                                        wx.redirectTo({
                                            url: "/page/common/msg/index"
                                        });
                                    }
                                });
                            }
                        }
                    })
                })

            },
            fail: function(res) {
                console.log(res.errMsg)
            }
        })
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