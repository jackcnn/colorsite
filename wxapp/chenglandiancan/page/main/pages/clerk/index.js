var app = getApp();
const show_cart = require('../../../../config').show_cart;
const print_cart = require('../../../../config').print_cart;

Page({
    data:{
        cartlist: [],
        total:0,
        inputValue:0,
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
                self.setData({
                    cartlist:res.data.cartlist,
                    total:res.data.total/100,
                    params:params
                });
            }
        });
    },
    onReady:function(){
        var self = this;
    },
    bindKeyInput:function (e) {
        this.setData({
            inputValue: e.detail.value
        })
    },
    bindInputfocus:function (e) {
        console.log(e)
        if(parseInt(e.detail.value)==0){
            console.log(1)
            this.setData({
                inputValue: ''
            })
        }
    },
    submit:function () {
        var self = this;
        wx.showActionSheet({
            itemList: ["确认打印(茶位费为￥"+self.data.inputValue+")"],
            success: function(res) {
                wx.showLoading({title: '加载中.'});
                wx.request({
                    url: print_cart+"?sid="+self.data.params.sid+"&tid="+self.data.params.tid,
                    data: {
                        invalue:self.data.inputValue,
                        cartlist:self.data.cartlist,
                        total:self.data.total
                    },
                    method:"post",
                    success: function(res) {
                        console.log(app.globalData)
                        if(res.data.success){
                            wx.setStorage({
                                key:'alert-flash',
                                data:{type:'success',msg:'提交成功！服务员马上过来确认'},
                                success:function () {
                                    wx.reLaunch({
                                        url: "/page/common/msg/msg"
                                    });
                                }
                            });
                        }else{
                            wx.setStorageSync('cart-list', {});
                            wx.setStorage({
                                key:'alert-flash',
                                data:{type:'error',msg:'提交失败'},
                                success:function () {
                                    wx.reLaunch({
                                        url: "/page/common/msg/msg"
                                    });
                                }
                            });
                        }
                    }
                })

            },
            fail: function(res) {
                console.log(res.errMsg)
            }
        })
    }

})