var app = getApp();
const getIndex = require('../../config').getIndex;
const getLists = require('../../config').getLists;
const host = require('../../config').host;


Page({
  data:{
      imgUrls:[
          host+'/uploads/tbk/image/banner1.png',
          host+'/uploads/tbk/image/banner2.png'
      ],
      list:[],
      category:[],
      curNav:0,
      page:1
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
                          curNav:category[0].favorites_id,
                          page:2,
                      })
                  }
              });
          });

    },
    showdetail:function (e) {
        wx.showLoading('加载中...');
        wx.setStorage({
            key:"tbk_item",
            data:e.currentTarget.dataset.item,
            success:function () {
                wx.navigateTo({
                    url: '/page/main/pages/detail/index'
                })
            }
        })

    },
    getlist:function(favorites_id,page,iscate){
        var self = this;
        wx.showLoading('加载中...');
        app.getUserOpenId(function(){
            wx.request({
                url:getLists,
                data: {
                    openid:app.globalData.openid,
                    favorites_id:favorites_id,
                    page:page
                },
                success: function(res) {
                    wx.hideLoading();
                    if(iscate){
                        var list = res.data.list;
                    }else{
                        if(res.data.list.length){
                            var list = self.data.list;
                            for(var i=0;i<res.data.list.length;i++){
                                list.push(res.data.list[i]);
                            }
                            page = page + 1;
                        }else{
                            var list = self.data.list;
                        }
                    }

                    self.setData({
                        list:list,
                        page:page
                    })
                }
            });
        });

    },
    selectCategory:function (e) {
        var self = this;
        var id = e.target.dataset.id;
        self.setData({
            curNav:id,
        })

        self.getlist(id,1,true);

    },
    onShareAppMessage: function (res) {
        if (res.from === 'button') {
            // 来自页面内转发按钮
            console.log(res.target)
        }
        return {
            title: '淘宝天猫内部优惠券，每日更新，速度来抢！',
            path: '/page/main/index',
            success: function(res) {
                // 转发成功
            },
            fail: function(res) {
                // 转发失败
            }
        }
    },
    onPageScroll:function(e){//分类导航
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
    },
    onReachBottom:function () {
        this.getlist(this.data.curNav,this.data.page,false);
    }
})
