<?php

class PageTool {

    /**
     * 生成分页代码.
     * @param integer $page
     * @param integer $size
     * @param integer $total
     * @param string $url
     * @param array $params
     * index.php?p=back&c=goods&a=list&cat_name=水&page=2&size=5
     * index.php?p=back&c=goods&a=list&cat_name=水&page=2&size=5&page=4&size=7
     */
    public function page($page, $size, $total, $url, array $params=array()) {
        //为了美化url的需要，我们需要分解url和params里面的参数，去重，以params为准
        //上一步合并后的参数数组，去掉page和size参数
        $urlInfo = parse_url($url);
        parse_str($urlInfo['query'], $query);
        $args = array_merge($query, $params);
        //去掉page和size参数，因为这两个要自动拼凑
        unset($args['size'], $args['page']);
        //将文件和参数合并成一个请求地址字符串
        $argments = http_build_query($args);
        $targetUrl = $urlInfo['path'] . '?' . $argments;
        //生成分页的html代码
        $totalPage = ceil($total / $size);
        $baseUrl = $targetUrl . '&size=' . $size . '&page=';
        $prePage = max($page - 1, 1);
        $nextPage = min($page + 1, $totalPage);

        $html = <<<page
    <div id="turn-page">
        总计<span id="totalRecords">$total</span>个记录
            分为<span id="totalPages">$totalPage</span>页
                当前第<span id="pageCurrent">$page</span>页，
                    每页<input type="text" size="3" id="pageSize" value="$size" onblur="location.href='$targetUrl&page=1&size='+this.value" />
        <span id="page-link">
          <a href="{$baseUrl}1">第一页</a>
          <a href="$baseUrl$prePage">上一页</a>
          <a href="$baseUrl$nextPage">下一页</a>
          <a href="$baseUrl$totalPage">最末页</a>
        <select id="goPage" onchange="gotoPage(this.value)">
page;
        for ($i = 1; $i <= $totalPage; ++$i) {
            if ($page == $i) {
                $html .= '<option value="' . $i . '" selected="true">' . $i . '</option>';
            } else {
                $html .= '<option value="' . $i . '">' . $i . '</option>';
            }
        }
        $html.=<<<page
            </select>
        </span>
    </div>
    <script type='text/javascript'>
            function gotoPage(page){
            location.href='$baseUrl' + page;
            }
    </script>
page;
        return $html;
    }

}
