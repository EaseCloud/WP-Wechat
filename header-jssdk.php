<?php

// WP_Wechat Handle
$wechat = new WP_Wechat();

// wechat-php-sdk Handle
$we = new Wechat(array(
    'appsecret' => $wechat->app_secret,
    'appid' => $wechat->app_id,
));
$auth = $we->checkAuth();
$js_ticket = $we->getJsTicket();
if(!$js_ticket) {
    $errcode = $we->errCode;
    $errtext = ErrCode::getErrText($weObj->errCode);
    echo "获取 js_ticket 失败！ 错误码：$errcode 错误原因：$errtext ";
}
$https = isset($_SERVER['HTTPS']) && 'on' === $_SERVER['HTTPS'];
$url = ($https?'https://':'http://')
    .$_SERVER['HTTP_HOST']
    .$_SERVER['REQUEST_URI'];
$js_sign = $we->getJsSign($url);
?>

<script>
    wx.config({
        debug: /debug=1/.test(location.href),
        appId: '<?php echo $js_sign['appId']; ?>', // 必填，公众号的唯一标识
        timestamp: <?php echo $js_sign['timestamp']; ?>, // 必填，生成签名的时间戳，切记时间戳是整数型，别加引号
        nonceStr: '<?php echo $js_sign['nonceStr']; ?>', // 必填，生成签名的随机串
        signature: '<?php echo $js_sign['signature']; ?>', // 必填，签名，见附录1
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onRecordEnd',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard'
        ]
    });
</script>
