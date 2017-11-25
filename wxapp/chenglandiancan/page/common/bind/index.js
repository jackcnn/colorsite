var app = getApp();
const bindclerk = require('../../../config').bindclerk;
Page({
    data: {
        store_name:"橙蓝网络",
        nickName:'',
        avatarUrl:'',
        params:{},
        had:false,
    },
    onLoad:function (params) {

        //page/common/bind/index?sid=1&clerkid=3

        var self = this ;
        self.setData({
            params:params
        });
        wx.showLoading();
        wx.request({
            url: bindclerk,
            data:{
                sid:params.sid,
                clerkid:params.clerkid
            },
            success: function(res) {
                wx.hideLoading();
                var store = res.data.store;
                var clerk = res.data.clerk;
                var had = res.data.had;

                wx.getUserInfo({
                    success: function(res) {
                        var userInfo = res.userInfo;
                        var nickName = userInfo.nickName;
                        var avatarUrl = userInfo.avatarUrl;
                        self.setData({
                            store_name:store.name,
                            nickName:nickName,
                            avatarUrl:avatarUrl,
                            had:had
                        });
                    }
                });
            }
        });


    },
    bindclerk:function () {

        var self = this;
        wx.showLoading({title: '加载中.'});
        app.getUserOpenId(function(){
            wx.request({
            url: bindclerk,
            data:{
                sid:self.data.params.sid,
                clerkid:self.data.params.clerkid,
                nickName:self.data.nickName,
                avatarUrl:self.data.avatarUrl,
                openid:app.globalData.openid
            },
            success: function(res) {
                if(res.data.success){
                    wx.setStorage({
                        key:'alert-flash',
                        data:{type:'success',msg:'绑定成功！'},
                        success:function () {
                            wx.reLaunch({
                                url: "/page/common/msg/index"
                            });
                        }
                    });
                }else{
                    wx.setStorage({
                        key:'alert-flash',
                        data:{type:'error',msg:'绑定失败！'},
                        success:function () {
                            wx.reLaunch({
                                url: "/page/common/msg/index"
                            });
                        }
                    });
                }
            }
        });
        })



    }
})

