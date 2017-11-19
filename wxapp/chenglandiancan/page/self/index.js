var app = getApp();
const getdishes = require('../../config').getdishes;
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
            url: getdishes,
            data:{
                sid:params.sid,
                tid:params.tid
            },
            success: function(res) {
                var store = res.data.store;
                var category = res.data.category;


                wx.setNavigationBarTitle({
                    title: store.name
                });

                try {//购物车
                    var cartlist = wx.getStorageSync('cart-list')
                    var total_count = 0;
                    var total_price = 0;
                    if (cartlist) {
                        category.forEach(function(value,key){
                            value.dishes.forEach(function (v,k) {
                                cartlist.forEach(function(cv,ck){
                                    if(cv.id == v.id){
                                        category[key].dishes[k].hascount = cv.count;
                                        total_count = total_count + cv.count;
                                        total_price = cv.count*v.price + total_price;
                                    }
                                })
                            })
                        })
                    }
                } catch (e) {
                    // Do something when catch error
                    console.log(e);
                }
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
        // self.data.category.forEach(function(cate,i){
        //     var query = wx.createSelectorQuery()
        //     query.select('#cate'+i).boundingClientRect()
        //     query.exec(function(res){
        //         hlist.push(res[0].top);
        //         self.setData({
        //             hlist:hlist
        //         })
        //     })
        // })

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
                wx.setStorage({
                    key:"cart-list",
                    data:[]
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

        wx.showActionSheet({
            itemList: ['提交菜单'],
            success: function(res) {
                //console.log(category)
                var arr = new Array();
                category.forEach(function(value,key){
                    value.dishes.forEach(function (v,k) {
                        if(parseInt(v.hascount)>0){
                            arr.push({id:v.id,count:v.hascount});
                        }
                    })
                });
                try {
                    wx.setStorageSync('category', category);
                } catch (e) {
                    console.log(e)
                }
                wx.setStorage({
                    key:"cart-list",
                    data:arr,
                    success:function (res) {
                        // wx.navigateTo({
                        //     url: '/page/self/pages/list/index?sid='+self.data.params.sid+'&tid='+self.data.params.tid
                        // })

                        wx.setStorage({
                            key:'alert-flash',
                            data:{type:'success',msg:'点菜成功，到店后扫码即可马上下单！'},
                            success:function () {
                                wx.navigateTo({
                                    url: "/page/common/msg/index"
                                });
                            }
                        });

                    }
                });
            },
            fail: function(res) {
                console.log(res.errMsg)
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