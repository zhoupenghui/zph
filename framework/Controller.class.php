<?php

class Controller {

    /**
     * 页面重定向。
     * @param string $url 要跳转的页面地址。
     * @param string $tips 提示文字。
     * @param integer $times 倒计时。
     */
    public function jump($url, $tips = '', $times = 1) {
        //如果没有提示文字，或者时间不合法，就立即跳转。
        if ($tips && $times > 0) {
            echo <<<jump
<!DOCTYPE html>
<html>
    <head>
        <title>页面跳转中...</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <style>
        html { height:100%;}
        a{text-decoration:none;}
        body { height:100%; text-align:center; background:transparent; font-size:12px;}
        .center_div { display:inline-block; zoom:1; *display:inline; vertical-align:middle;  width:200px; padding:10px; }
        .hiddenDiv { height:100%; overflow:hidden; display:inline-block; width:1px; overflow:hidden; margin-left:-1px; zoom:1; *display:inline; *margin-top:-1px; _margin-top:0; vertical-align:middle;}
        .loading_block{background:url(public/images/load_bg.gif) left top no-repeat; width:506px; height:207px;}
        .loading_onclick{text-align:right; padding:28px 25px 0 0}
        .loading_bar{margin-top:80px;}
        </style>
    </head>
    <body>

                        <div class="center_div loading_block">
      <div class="loading_bar"><img src="public/images/loading_page.gif" width="220" height="19" /><p>$tips</p></div><span id="times">$times</span>秒后，跳转到<a href="$url">目标页面</a>
      <div class="loading_onclick">如果浏览器没有自动跳转，请<a href="$url" > 点击这里 </a></div>
    </div>
    <div class="hiddenDiv"></div>
        <script type="text/javascript">
            var timesEle = document.getElementById('times');
            var times = '$times';
            var url = '$url';
            function jump() {
                times--;
                timesEle.innerText = times;
                if (times < 1) {
                    clearInterval(interval);
                    location.href = url;
                }
            }
            var interval = setInterval('jump()', 1000);
        </script>
    </body>
</html>
jump;
        } else {
            header('Location: ' . $url);
        }
        exit;
    }

}
