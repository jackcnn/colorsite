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
    title: '自定义分享', // 分享标题
    desc: '自定义分享的描述', // 分享描述
    link: location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
    imgUrl: 'https://326108993.com/uploads/00039/201709/57bddbc0f4987815c5ad93d4c3ed722b.jpg', // 分享图标
    type: 'link', // 分享类型,music、video或link，不填默认为link
    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    success: function () { 
        // 用户确认分享后执行的回调函数
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
    }
});


JS;

$this->registerJS($js);