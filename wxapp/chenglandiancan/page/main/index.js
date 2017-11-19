var app = getApp();
const mchlist = require('../../config').mchlist;
const host = require('../../config').host;

Page({
  data:{
      list: [],
      host:host,
      lat:0,
      lng:0,
      keyword:'',
  },
  onLoad:function () {

      var self = this;
      wx.getLocation({
          type: 'wgs84',
          success: function(res) {
              var latitude = res.latitude;
              var longitude = res.longitude;
              var speed = res.speed;
              var accuracy = res.accuracy;

              console.log(latitude+'--'+longitude);

              self.getmchlist(latitude,longitude,"");

          },fail:function (res) {

              self.getmchlist(0,0,"");

          }
      })


  },
  getmchlist:function (lat,lng,keyword) {
      var self = this;
      wx.showLoading();
      wx.request({
          url: mchlist,
          data:{
              lat:lat,
              lng:lng,
              keyword:encodeURI(keyword)
          },
          success: function(res) {
              wx.hideLoading();

              if(res.data.list.length){

                  if(keyword){
                      var list = [];
                  }else{
                      var list = self.data.list;
                  }

                  for(var i=0;i<res.data.list.length;i++){
                      list.push(res.data.list[i]);
                  }

                  self.setData({
                      list:list,
                      lat:lat,
                      lng:lng,
                      keyword:keyword
                  })
              }
          }
      });
  },
  dosearch:function (e) {
      var keyword = e.detail.value;

      var self = this;
      var lat = self.data.lat;
      var lng = self.data.lng;

      self.getmchlist(lat,lng,keyword);

  }  
})
