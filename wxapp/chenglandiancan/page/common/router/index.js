var app = getApp();
const router = require('../../../config').router;

const queryString = require('../../../util/util').queryString;

Page({
    data:{
    },
    onLoad:function(params)
    {
        var self = this;
        //自定义二维码扫描进入
        var url =decodeURIComponent(params.q);

        var stid = queryString(url,'stid');

        var st_arr = stid.split("-");

        var sid = st_arr[0];
        var tid = st_arr[1];
        var type = st_arr[2];

        if(type == "BIND"){
            wx.reLaunch({
                url: "/page/common/bind/index?sid="+sid+"&clerkid="+tid
            });
            return;
        }

        wx.showLoading('请稍后...');

        if(sid && tid){
            app.getUserOpenId(function(){
                wx.request({
                    url:router,
                    data: {
                        sid:sid,
                        tid:tid,
                        openid:app.globalData.openid
                    },
                    success: function(res) {
                        console.log(res.data)
                        var path = res.data.path;
                        wx.reLaunch({
                            url: path
                        });
                    }
                });
            });
        }else{
            wx.reLaunch({
                url: "/page/main/index"
            });
        }
    }

})