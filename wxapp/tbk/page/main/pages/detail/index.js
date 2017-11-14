var app = getApp();
const getKoulin = require('../../../../config').getKoulin;
Page({
    data:{
        item: {},
        detail_images:{},
        koulin:'',
    },
    onLoad:function()
    {
        var self = this;
        wx.getStorage({
            key: 'tbk_item',
            success: function(res) {
                // console.log(res.data)
                wx.hideLoading();
                self.setData({
                    item:res.data
                });
            }
        });
    },
    submit:function () {
        var self = this ;

        if(self.data.koulin.length){
            wx.setClipboardData({
                data: self.data.koulin,
                success: function(res) {
                    wx.showModal({
                        title: '提示',
                        showCancel:false,
                        confirmText:'我知道啦',
                        confirmColor:'#ff5500',
                        content: '口令已复制，打开手机淘宝即可购买！',
                        success: function(res) {
                        }
                    });
                }
            })
            return;
        }

        wx.showLoading('加载中...');
        if(self.data.item.coupon_click_url){
            var url = self.data.item.coupon_click_url;
        }else if(self.data.item.click_url){
            var url = self.data.item.click_url;
        }else{
            var url = self.data.item.item_url;
        }

        wx.request({
            url:getKoulin,
            data: {
                url:encodeURI(url)
            },
            success: function(res) {
                wx.hideLoading();
                if(res.data.success){
                    var data = res.data.data;
                    var model = data.data.model;


                    self.setData({
                        koulin:model
                    })

                    wx.setClipboardData({
                        data: model,
                        success: function(res) {
                            wx.showModal({
                                title: '提示',
                                showCancel:false,
                                confirmText:'我知道啦',
                                confirmColor:'#ff5500',
                                content: '口令已复制，打开手机淘宝即可购买！',
                                success: function(res) {
                                }
                            });
                        }
                    })
                }
            }
        });
    },
    onShareAppMessage: function (res) {
        if (res.from === 'button') {
            // 来自页面内转发按钮
            console.log(res.target)
        }
        return {
            title: '淘宝天猫内部优惠券，每日更新，速度来抢！',
            path: '/page/main/index',
            success: function(res) {
                // 转发成功
            },
            fail: function(res) {
                // 转发失败
            }
        }
    },
    loadImg:function (e) {
        this.setData({
            swiperHeight:e.detail.height
        });
    }
})