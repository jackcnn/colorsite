var app = getApp();
const getKoulin = require('../../../../config').getKoulin;
Page({
    data:{
        item: {},
        detail_images:{},
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
            }
        });




        // wx.setClipboardData({
        //     data: data,
        //     success: function(res) {
        //         wx.showModal({
        //             title: '提示',
        //             content: '这是一个模态弹窗',
        //             success: function(res) {
        //             }
        //         })
        //     }
        // })
    },
    loadImg:function (e) {
        this.setData({
            swiperHeight:e.detail.height
        });
    }
})