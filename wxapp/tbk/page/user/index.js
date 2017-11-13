var app = getApp();
const submit = require('../../config').submit;

Page({
    data:{
        list: [],
    },
    onLoad:function(params)
    {
        var self = this;
    },
    formSubmit:function (e) {
        var tel = e.detail.value.tel;
        var ways = e.detail.value.ways;
        var desc = e.detail.value.desc;
        if(!tel || ways.length<1){
            console.log("手机号和合作方式必须填写！");
            return;
        }

        app.getUserOpenId(function(){
            wx.request({
                url:submit,
                method:'post',
                data: {
                    openid:app.globalData.openid,
                    tel:tel,
                    ways:ways,
                    desc:desc
                },
                success: function(res) {
                    if(res.data.success){
                        var msg = "信息提交成功，我们将尽快练习你！";
                    }else{
                        var msg = res.data.msg;
                    }
                    wx.showModal({
                        title: '提示',
                        showCancel:false,
                        confirmText:'我知道啦',
                        confirmColor:'#ff5500',
                        content: msg,
                        success: function(res) {
                        }
                    });
                }
            });
        });






    }

})