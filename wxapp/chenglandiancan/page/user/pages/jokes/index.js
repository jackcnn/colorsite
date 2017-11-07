var app = getApp();
const jokelist = require('../../../../config').jokelist;


Page({
    data:{
        list: [],
        loading:false,
    },
    onLoad:function()
    {
        var self = this;

        self.getdata();

    },
    getdata:function () {
        var self = this;
        self.setData({
            loading:true
        })
        wx.request({
            url: jokelist,
            data:{
            },
            success: function(res) {
                var data = res.data.list;
                var list = self.data.list;

                data.forEach(function(v,k){
                    list.push(v);
                })

                self.setData({
                    list:list,
                    loading:false
                });
            }
        });
    }
})