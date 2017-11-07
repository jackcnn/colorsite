var app = getApp();
const router = require('../../config').router;

Page({
  data:{
  },
  onLoad:function(params)
  {
        var self = this;
        if(params.sid && params.tid){
            wx.showLoading('请稍后...');
            app.getUserOpenId(function(){
                wx.request({
                    url:router,
                    data: {
                        sid:params.sid,
                        tid:params.tid,
                        openid:app.globalData.openid
                    },
                    success: function(res) {
                        wx.hideLoading();
                        console.log(res.data)
                        var path = res.data.path;
                        wx.navigateTo({
                            url: path
                        });

                    }
                });
            });
        }

    },
  scan:function () {
      wx.scanCode({
          onlyFromCamera: true,
          success: (res) => {
            console.log(res)
          if(res.path){
                  wx.reLaunch({
                      url: "/"+res.path
                  });
          }
      }
      })
  }
})
