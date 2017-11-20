var app = getApp();
const host = require("../../../../config").host;
Page({
    data:{
        imgUrls:[
            host+'/wxapp/images/ba1.png',
            host+'/wxapp/images/ba2.png',
            host+'/wxapp/images/ba3.png',
        ],
        headers:[
            {image:'images/company.png',title:'开公司'},
            {image:'images/book.png',title:'代记账'},
            {image:'images/honor.png',title:'办资质'},
            {image:'images/ask.png',title:'咨询'},
        ],
        swiperHeight:420
    },
    onLoad:function()
    {
    },
    loadImg:function (e) {
        this.setData({
            swiperHeight:e.detail.height
        });
    }
})