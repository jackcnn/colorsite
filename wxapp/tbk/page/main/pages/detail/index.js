var app = getApp();
const getdishes = require('../../../../config').getdishes;
Page({
    data:{
        item: {},
    },
    onLoad:function()
    {
        var self = this;

        wx.getStorage({
            key: 'tbk_item',
            success: function(res) {
                self.setData({
                    item:res.data
                })
            }
        })




    },

})