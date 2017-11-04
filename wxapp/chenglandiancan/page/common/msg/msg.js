var app = getApp();

Page({
    data:{
        msg:'提示信息',
        type:'success',
        color:'#13CE66',
    },
    onLoad:function()
    {
        var self = this;
        wx.getStorage({
            key: 'alert-flash',
            success: function(res) {
                var data = res.data;
                if(data){
                    if(data.type =="success"){
                        var color="#13CE66";
                    }else{
                        var color="#FF4949";
                    }
                    self.setData({
                        msg:data.msg,
                        type:data.type,
                        color:color,
                    })
                }
            }
        })

    }
})