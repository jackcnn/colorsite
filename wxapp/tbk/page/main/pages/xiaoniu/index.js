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
            {image:host+'/wxapp/images/company.png',title:'开公司'},
            {image:host+'/wxapp/images/book.png',title:'代记账'},
            {image:host+'/wxapp/images/honor.png',title:'办资质'},
            {image:host+'/wxapp/images/ask.png',title:'咨询'},
        ],
        swiperHeight:240
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