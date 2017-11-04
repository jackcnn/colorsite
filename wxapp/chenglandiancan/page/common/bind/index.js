var app = getApp();
const bindclerk = require('../../../config').bindclerk;
Page({
    data: {
        store_name:"橙蓝网络"
    },
    onLoad:function (params) {
        var self = this ;
        wx.request({
            url: bindclerk,
            data:{
                sid:params.sid,
                clerkid:params.clerkid
            },
            success: function(res) {
                var store = res.data.store;
                var clerk = res.data.clerk;

                console.log(res.data);

                self.setData({
                    store_name:store.name
                })


            }
        });


    },
    bindclerk:function () {




    }
})

