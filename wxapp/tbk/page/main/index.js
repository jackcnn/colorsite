var app = getApp();
const getIndex = require('../../config').getIndex;
const getLists = require('../../config').getLists;


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
                      self.setData({
                          category:category,
                          list:list,
                          curNav:category[0].favorites_id
                      })
                  }
              });
          });

    },
    getlist:function(favorites_id){
        var self = this;
        wx.showLoading('加载中...');
        app.getUserOpenId(function(){
            wx.request({
                url:getLists,
                data: {
                    openid:app.globalData.openid,
                    favorites_id:favorites_id
                },
                success: function(res) {
                    wx.hideLoading();
                    var list = res.data.list;
                    self.setData({
                        list:list,
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

        self.getlist(id);

    },
    onPageScroll:function(e){

        if((!this.data.posNav)&&(e.scrollTop > 200)){
            this.setData({
                posNav:true
            })
        }

        if((this.data.posNav)&&(e.scrollTop < 200)){
            this.setData({
                posNav:false
            })
        }



    }
})
