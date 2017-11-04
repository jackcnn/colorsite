var app = getApp();
const submit_cart = require('../../../../config').submit_cart;

Page({
    data:{
        list: [],
        category:[],
        total_price:0,
        params:{},
    },
    onLoad:function(params)
    {
        var self = this;
        wx.getStorage({
            key: 'category',
            success: function(res) {
                var category = res.data;
                var total = 0;
                category.forEach(function(value,key){
                    value.dishes.forEach(function (v,k) {
                        if(v.hascount >0){
                            total = parseInt(v.hascount*v.price) + total;
                        }
                    });
                })

                self.setData({
                    category:res.data,
                    total_price:total/100,
                    params:params
                })
            }
        })

    },
    onReady:function(){
        var self = this;
    },
    click_label:function (e) {
        var self = this;
        var cid = e.target.dataset.cid;
        var did = e.target.dataset.did;
        var ix = e.target.dataset.ix;

        var category = self.data.category;

        var check_sel = category[cid].dishes[did].label_list[ix].sel;
        if(check_sel > 0){
            category[cid].dishes[did].label_list[ix].sel = 0;
        }else{
            category[cid].dishes[did].label_list[ix].sel = 1;
        }

        self.setData({
            category:category
        })

    },
    submit:function () {
        var self = this;

        var category = self.data.category;

        var res_list = [];

        category.forEach(function(value,key){
            value.dishes.forEach(function (v,k) {
                if(v.hascount >0){
                    var label="";
                    if(v.label_list){
                        v.label_list.forEach(function(vv,kk){
                            if(vv.sel>0){
                                label = label + "," + vv.name;
                            }
                        });
                    }

                    res_list.push({id:v.id,count:v.hascount,name:v.name,price:v.price,lable:label});
                }
            });
        });



        wx.showActionSheet({
            itemList: ['确认呼叫服务员下单'],
            success: function(res) {
                wx.showLoading({title: '加载中.'});
                wx.request({
                    url: submit_cart+"?sid="+self.data.params.sid+"&tid="+self.data.params.tid,
                    data: {
                        res_list:res_list,
                        openid:app.globalData.openid
                    },
                    method:"post",

                    success: function(res) {
                        console.log(app.globalData)
                        if(res.data.success){
                            wx.setStorage({
                                key:'alert-flash',
                                data:{type:'success',msg:'提交成功！服务员马上过来确认'},
                                success:function () {
                                    wx.reLaunch({
                                        url: "/page/common/msg/msg"
                                    });
                                }
                            });
                        }else{
                            wx.setStorageSync('cart-list', {});
                            wx.setStorage({
                                key:'alert-flash',
                                data:{type:'error',msg:'提交失败'},
                                success:function () {
                                    wx.reLaunch({
                                        url: "/page/common/msg/msg"
                                    });
                                }
                            });
                        }
                    }
                })

            },
            fail: function(res) {
                console.log(res.errMsg)
            }
        })


    }

})