var app = getApp();
const getIndex = require('../../config').getIndex;

Page({
  data:{
      imgUrls:[
          '../../../image/wechat.png',
          '../../../image/wechatHL.png'
      ],
      list:[],
      category:[],
      curNav:0,
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

                    var list = res.data.list;


                    console.log(res.data.list)

                    self.setData({
                        category:category,
                        list:list,
                        curNav:category[0].favorites_id
                    })

                }
            });
        });

    },
    selectCategory:function (e) {
        var self = this;
        var id = e.target.dataset.id;

        self.setData({
            curNav:id
        })


    }
})
