var app = getApp();
const show_cart = require('../../../../config').show_cart;
const createorder = require('../../../../config').createorder;

Page({
    data:{
        list: [],
        params:{},
        total_price:0,
        true_price:0,
        openid:'',
    },
    onLoad:function(params)
    {
        var self = this;

        app.getUserOpenId(function () {
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
                        total_price:total_price/100,
                        true_price:total_price/100,
                        params:params,
                        openid:app.globalData.openid
                    });
                }
            });
        })


    },
    bindKeyInput:function (e) {
        this.setData({
            true_price: e.detail.value
        })
    },
    submit:function (e) {

        var self = this;
        var category = self.data.category;
        var formId = e.detail.formId;

        wx.showActionSheet({
            itemList: ['微信支付','现金或其他方式支付'],
            success: function(res) {
                var tapIndex = parseInt(res.tapIndex);

                if(tapIndex == 0){
                    self.createorder(self.data,"weixin",formId);
                }

                if(tapIndex == 1 ){//确认设置微信付款吗.设置现金付款--跳转到设置页面
                    self.createorder(self.data,"other",formId);
                }


            },
            fail: function(res) {
                console.log(res.errMsg)
            }
        })
    },
    createorder:function (data,type,formId) {

        var category = data.category;
        var res_list = [];

        category.forEach(function(value,key){
            value.dishes.forEach(function (v,k) {
                if(v.hascount >0){
                    var label="";
                    res_list.push({id:v.id,count:v.hascount,name:v.name,price:v.price,lable:label});
                }
            });
        });

        wx.request({
            url: createorder+"?sid="+data.params.sid+"&tid="+data.params.tid,
            method:"post",
            data:{
                truepay:data.true_price,
                type:type,
                res_list:res_list,
                openid:data.openid,
                formId:formId
            },
            success: function(res) {

                if(res.data.success){

                    // wx.reLaunch({
                    //     url: "/page/main/pages/checkpay/index?sid="+data.params.sid+"&tid="+data.params.tid+"&orderid="+res.data.orderid+"&ordersn="+res.data.ordersn
                    // });
                    wx.redirectTo({
                        url: "/page/main/pages/checkpay/index?sid="+data.params.sid+"&tid="+data.params.tid+"&orderid="+res.data.orderid+"&ordersn="+res.data.ordersn
                    });


                }else{
                    console.log(res.data)
                }

            }
        });



    }
})