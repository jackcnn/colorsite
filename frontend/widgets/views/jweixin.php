<?php
/**
 * Date: 2017/9/27 0027
 * Time: 16:58
 */
$this->registerJsFile("https://res.wx.qq.com/open/js/jweixin-1.2.0.js");


$js = <<<JS

wx.config({
    debug: true,
    appId: "{$data['appId']}",
    timestamp: "{$data['timestamp']}",
    nonceStr: "{$data['nonceStr']}",
    signature: "{$data['signature']}",
    jsApiList: [
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'chooseWXPay',
    ]
});

wx.onMenuShareTimeline({
    title: '自定义分享',
    link: location.href,
    imgUrl: 'https://326108993.com/uploads/00039/201709/57bddbc0f4987815c5ad93d4c3ed722b.jpg',
    success: function () { 
       
    },
    cancel: function () { 
        
    }
});

wx.onMenuShareAppMessage({
    title: '自定义分享',
    desc: '自定义分享的描述',
    link: location.href,
    imgUrl: 'https://326108993.com/uploads/00039/201709/57bddbc0f4987815c5ad93d4c3ed722b.jpg',
    success: function () { 
       
    },
    cancel: function () { 
        
    }
});


JS;

$this->registerJS($js);