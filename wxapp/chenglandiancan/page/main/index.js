Page({
  data:{

  },
  onReady:function()
  {
    var self = this;

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
          }else{
          }
      }
      })
  }
})
