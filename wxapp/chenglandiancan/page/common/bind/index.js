var app = getApp();
const bindclerk = require('../../../config').bindclerk;
Page({
    data: {
        store_name:"橙蓝网络",
        nickName:'',
        avatarUrl:'',
        params:{},
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

                wx.getUserInfo({
                    success: function(res) {
                        var userInfo = res.userInfo;
                        var nickName = userInfo.nickName;
                        var avatarUrl = userInfo.avatarUrl;

                        self.setData({
                            store_name:store.name,
                            nickName:nickName,
                            avatarUrl:avatarUrl,
                            params:params
                        });
                    }
                });
            }
        });


    },
    bindclerk:function () {

        var self = this;
        console.log(self.data.nickName)
        wx.request({
            url: bindclerk,
            data:{
                sid:params.sid,
                clerkid:params.clerkid,
                nickName:self.data.nickName,
                avatarUrl:self.data.avatarUrl,
                openid:app.globalData.openid
            },
            success: function(res) {
                console.log(res)
                if(res.data.success){

                }else{

                }
            }
        });



    }
})

