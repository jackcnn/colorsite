var app = getApp();
const host = require('../../config').host;
const getIndex = require('../../config').getIndex;


Page({
  data:{
      array: [
          '自动识别（中英文互转）',
          '中文  =>  英文',
          '英文  =>  中文',
          '中文  =>  西班牙文',
          '西班牙文  =>  中文',
          '中文  =>  法文',
          '法文  =>  中文',
          '英文  =>  越南语',
          '越南语  =>  英文',
          '中文  =>  粤语',
          '粤语  =>  中文',
          '中文  =>  韩文',
          '英文  =>  德语',
          '德语  =>  英文',
          '中文  =>  日文',
          '日文  =>  中文'
      ],
      index:0,
      text:''
  },
  onLoad:function(params)
  {
        var self = this;

  },
  formSubmit:function (e) {
        var self = this;

        var type = self.data.index ;

        var text = e.detail.value.content;


      wx.showLoading('加载中...');
      wx.request({
          url:getIndex,
          method:"post",
          data: {
              text:text,
              type:type
          },
          success: function(res) {
              wx.hideLoading();
              var res = res.data;

              self.setData({
                  text:res.data.trans_text
              })

          }
      });

  },
  copy:function(){
      var self = this;
      wx.setClipboardData({
          data: self.data.text,
          success: function(res) {
              wx.showModal({
                  title: '温馨提示',
                  showCancel:false,
                  confirmText:'我知道啦',
                  confirmColor:'#20a0ff',
                  content: '复制成功！',
                  success: function(res) {
                  }
              });
          }
      })



  },
  formReset:function () {

      this.setData({
          text:'',
      })

  },
  bindPickerChange: function(e) {
        //console.log('picker发送选择改变，携带值为', e.detail.value)
        this.setData({
            index: e.detail.value
        })
  },
  onShareAppMessage: function (res) {
        if (res.from === 'button') {
            console.log(res.target)
        }
        return {
            title: '橙蓝翻译小程序！',
            path: '/page/main/index',
            success: function(res) {
                // 转发成功
            },
            fail: function(res) {
                // 转发失败
            }
        }
  },
})
