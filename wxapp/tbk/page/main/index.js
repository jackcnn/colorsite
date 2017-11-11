var app = getApp();
const getIndex = require('../../config').getIndex;

Page({
  data:{
      imgUrls:[
          '../../../image/wechat.png',
          '../../../image/wechatHL.png'
      ],
      list:[],
      category:[]
  },
  onLoad:function(params)
  {
        var self = this;

        wx.showLoading('请稍后...');
        app.getUserOpenId(function(){
            wx.request({
                url:getIndex,
                data: {
                    openid:app.globalData.openid
                },
                success: function(res) {
                    wx.hideLoading();
                    var category = res.data.category;

                    if(res.data.list.length > 1){
                        var list = res.data.list;
                    }else{
                        var list = [];
                    }

                    self.setData({
                        category:category,
                        list:list
                    })

                }
            });
        });

    },
})
