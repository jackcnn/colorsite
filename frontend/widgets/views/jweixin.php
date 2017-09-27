<?php
/**
 * Date: 2017/9/27 0027
 * Time: 16:58
 */
$this->registerJsFile("https://res.wx.qq.com/open/js/jweixin-1.2.0.js");


$js = <<<JS

wx.config({
    debug: false,
    appId: "{$data['appId']}",
    timestamp: "{$data['timestamp']}",
    nonceStr: "{$data['nonceStr']}",
    signature: "{$data['signature']}",
    jsApiList: [
        'onMenuShareTimeline',
        'chooseWXPay',
    ]
});

JS;

$this->registerJS($js);