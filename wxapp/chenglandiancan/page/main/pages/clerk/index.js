var app = getApp();
const show_cart = require('../../../../config').show_cart;
const clerk_submit_cart = require('../../../../config').clerk_submit_cart;

Page({
    data:{
        list: [],
        category:[],
        curNav:0,
        total_count:0,
        total_price:0,
        togglecart:false,
        hlist:[],//保存分类所属的离顶部高度
        dishescateview:'',//当前可见
        params:{},
    },
    onLoad:function(params)
    {
        var self = this;

        wx.request({
            url: show_cart,
            data:{
                sid:params.sid,
                tid:params.tid
            },
            success: function(res) {
                var store = res.data.store;
                var category = res.data.category;
                var total_count = res.data.total_count;
                var total_price = res.data.total;

                wx.setNavigationBarTitle({
                    title: store.name
                });

                self.setData({
                    category:category,
                    total_count:total_count,
                    total_price:total_price/100,
                    params:params
                });
            }
        });

    },
    onReady:function(){
        var self = this;
        var hlist = [];

    },
    increase:function(e){
        var self = this;
        var cindex = e.target.dataset.cindex;
        var dindex = e.target.dataset.dindex;

        var category = self.data.category;
        var new_num = parseInt(category[cindex].dishes[dindex].hascount) + 1 ;

        category[cindex].dishes[dindex].hascount = new_num;

        var total_count = 0;
        var total_price = 0;
        category.forEach(function(value,key){
            value.dishes.forEach(function (v,k) {
                total_count = parseInt(v.hascount) + total_count;
                total_price = parseInt(v.hascount*v.price) + total_price;
            })
        })
        self.setData({
            category:category,
            total_count:total_count,
            total_price:total_price/100
        })
    },
    decrease:function(e){
        var self = this;
        var cindex = e.target.dataset.cindex;
        var dindex = e.target.dataset.dindex;

        var category = self.data.category;
        var num = parseInt(category[cindex].dishes[dindex].hascount);
        if(num >0){
            var new_num = num-1;
        }else{
            var new_num = 0 ;
        }
        category[cindex].dishes[dindex].hascount = new_num;

        var total_count = 0;
        var total_price = 0;
        category.forEach(function(value,key){
            value.dishes.forEach(function (v,k) {
                total_count = parseInt(v.hascount) + total_count;
                total_price = parseInt(v.hascount*v.price) + total_price;
            })
        })
        self.setData({
            category:category,
            total_count:total_count,
            total_price:total_price/100
        })

    },
    toggleCart:function () {
      this.setData({
          togglecart:!this.data.togglecart
      })
    },
    clearcart:function (e) {
        var self = this;
        var category = self.data.category;

        wx.showActionSheet({
            itemList: ['清空列表'],
            success: function(res) {
                category.forEach(function(value,key){
                    value.dishes.forEach(function (v,k) {
                        category[key].dishes[k].hascount = 0;
                    })
                })
                self.setData({
                    category:category,
                    total_count:0,
                    total_price:0,
                    togglecart:false,
                });
            },
            fail: function(res) {
                console.log(res.errMsg)
            }
        })


    },
    submit:function () {

        var self = this;
        var category = self.data.category;
        var params = self.data.params;

        wx.showActionSheet({
            itemList: ['确认下单','设置结账','重置餐牌'],
            success: function(res) {
                var tapIndex = parseInt(res.tapIndex);
                if(tapIndex == 0){
                    self.print_list(category,params);
                }

                if(tapIndex == 1 ){//确认设置微信付款吗.设置现金付款--跳转到设置页面
                    wx.navigateTo({
                        url: "/page/main/pages/checkout/index?sid="+params.sid+"&tid="+params.tid
                    })
                    return;
                }

                if(tapIndex == 2){
                    wx.showActionSheet({
                        itemList:['确认重置餐牌吗？'],
                        success:function () {

                        }
                    })
                }

            },
            fail: function(res) {
                console.log(res.errMsg)
            }
        })
    },
    print_list:function(category,params){

        var res_list = [];
        category.forEach(function(value,key){
            value.dishes.forEach(function (v,k) {
                if(v.hascount >0){
                    var label="";

                    res_list.push({id:v.id,count:v.hascount,name:v.name,price:v.price,lable:label});
                }
            });
        }); //点菜单

        wx.request({
            url: clerk_submit_cart+"?sid="+params.sid+"&tid="+params.tid,
            data: {
                res_list:res_list,
            },
            method:"post",
            success: function(res) {
                if(res.data.success){
                    wx.setStorage({
                        key:'alert-flash',
                        data:{type:'success',msg:'提交成功！'},
                        success:function () {
                            // wx.reLaunch({
                            //     url: "/page/common/msg/index"
                            // });
                            wx.redirectTo({
                                url: "/page/common/msg/index"
                            });
                        }
                    });
                }else{
                    wx.setStorage({
                        key:'alert-flash',
                        data:{type:'error',msg:'提交失败'},
                        success:function () {
                            // wx.reLaunch({
                            //     url: "/page/common/msg/index"
                            // });
                            wx.redirectTo({
                                url: "/page/common/msg/index"
                            });

                        }
                    });
                }
            }
        })
    },
    tapcategory:function(e){
        var self = this;
        var index = e.target.dataset.index;
        var view_id = "cate"+index;

        self.setData({
            curNav:index,
            dishescateview:view_id,
            tap:1
        })

    },
    onScroll:function (e){
        var self = this;
        // if(!self.data.tap){
        //     var scale = e.detail.scrollWidth / 570,
        //         scrollTop = e.detail.scrollTop / scale;
        //     var hlist = self.data.hlist;
        //     var hlen = hlist.length;
        //     var ii=self.data.curNav;
        //     for(var i=0;i<hlen;i++){
        //         if(i<hlen-1){
        //             if(e.detail.scrollTop+32 < hlist[i+1]){
        //                 ii = i;
        //                 break;
        //             }
        //         }else{
        //             ii = i;
        //             break;
        //         }
        //     }
        //     self.setData({
        //         curNav:ii
        //     })
        // }
    },

})