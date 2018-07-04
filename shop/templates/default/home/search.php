<?php defined('In33hao') or exit('Access Invalid!'); ?>
<script src="<?php echo SHOP_RESOURCE_SITE_URL . '/js/search_goods.js'; ?>"></script>
<link href="<?php echo SHOP_TEMPLATES_URL; ?>/css/layout.css" rel="stylesheet" type="text/css">
<style type="text/css">
    body {
        _behavior: url(<?php echo SHOP_TEMPLATES_URL;
?>/css/csshover.htc);
    }
</style>
<div id="nav-search" class="wrapper nch-breadcrumb-layout">
    <?php if (!empty($output['nav_link_list']) && is_array($output['nav_link_list'])) { ?>
        <?php foreach ($output['nav_link_list'] as $nav_link) { ?>
            <?php if (!empty($nav_link['link'])) { ?>
                <?php
                $model_goods_class = Model('goods_class');
                $nav_info = $model_goods_class->getGoodsClassList(array('gc_id' => $nav_link['id']));
                $where = array();
                $where['gc_id'] = array('not in', $nav_link['id']);
                $where['gc_parent_id'] = $nav_info[0]['gc_parent_id'];
                $nav_list = $model_goods_class->getGoodsClassList($where);
                ?>
                <div class="nch-breadcrumb">
     <span class="sort-box"> <a href="<?php echo $nav_link['link']; ?>"
                                class="current"><?php echo $nav_link['title']; ?><i class="drop-arrow"></i></a>
         <?php if (!empty($nav_list)) { ?>
             <div class="sort-sub">
        <ul>
         <?php foreach ($nav_list as $key => $val) { ?>
             <li><a href="<?php echo urlShop('search', 'index', array('cate_id' => $val['gc_id'], 'keyword' => $_GET['keyword'])); ?>"><?php echo $val['gc_name'] ?></a></li>
         <?php } ?>
        </ul>
      </div>
         <?php } ?>
       </span><span class="arrow">&gt;</span>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    <div class="clear"></div>
</div>

<div class="nch-container wrapper">

    <!-- 分类下的推荐商品 -->
    <div id="gc_goods_recommend_div" class="wrapper"></div>
    <div class="nch-module">
        <div class="title">
            <h3>
                <?php if (!empty($output['show_keyword'])) { ?>
                    <em><?php echo $output['show_keyword']; ?></em> -
                <?php } ?>
                商品筛选<i>搜索到<?php echo $output['goods_num']; ?>件相关商品</i></h3>
        </div>
        <div class="content">
            <div class="nch-module-filter">
                <div id="insert">

                </div>
                <?php $dl = 1;  //dl标记?>
                <?php if (!empty($output['goods_class_array']) and isset($output['goods_class_array'])): ?>
                    <dl>
                        <dt><span>包含分类<?php echo $lang['nc_colon']; ?></span></dt>
                        <dd class="list">
                            <ul>
                                <?php foreach ($output['goods_class_array'] as $key => $value) { ?>
                                    <li>
                                        <a href="/shop/index.php?act=search&op=index&cate_id=<?php echo $value['gc_id']; ?>"><?php echo $value['gc_name']; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </dd>
                    </dl>
                <?php endif; ?>
                <?php $dl = 1;
                $num_dl = 1;  //dl标记?>

            </div>

        </div>

    </div>

    <?php if ($num_dl > 4) { ?>
        <div id="more_select_nav"><a href="javascript:void(0);" class="down"><span>更多选项&nbsp;</span><i
                        class="icon-angle-down"></i></i></a></div>
    <?php } ?>
    <div class="shop_con_list" id="main-nav-holder">
        <nav class="sort-bar" id="main-nav">
            <div class="pagination"><?php echo $output['show_page1']; ?> </div>
            <div class="nch-all-category">
                <div class="all-category">
                    <?php require template('layout/home_goods_class'); ?>
                </div>
            </div>
            <div class="nch-sortbar-array"> 排序方式：
                <ul>
                    <li <?php if (!$_GET['key']){ ?>class="selected"<?php } ?>><a
                                href="<?php echo dropParam(array('order', 'key')); ?>"
                                title="<?php echo $lang['goods_class_index_default_sort']; ?>"><?php echo $lang['goods_class_index_default']; ?></a>
                    </li>
                    <li <?php if ($_GET['key'] == '1'){ ?>class="selected"<?php } ?>><a
                                href="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '1') ? replaceParam(array('key' => '1', 'order' => '1')) : replaceParam(array('key' => '1', 'order' => '2')); ?>"
                                <?php if ($_GET['key'] == '1'){ ?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc'; ?>"<?php } ?>
                                title="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '1') ? $lang['goods_class_index_sold_asc'] : $lang['goods_class_index_sold_desc']; ?>"><?php echo $lang['goods_class_index_sold']; ?>
                            <i></i></a></li>
                    <li <?php if ($_GET['key'] == '2'){ ?>class="selected"<?php } ?>><a
                                href="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '2') ? replaceParam(array('key' => '2', 'order' => '1')) : replaceParam(array('key' => '2', 'order' => '2')); ?>"
                                <?php if ($_GET['key'] == '2'){ ?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc'; ?>"<?php } ?>
                                title="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '2') ? $lang['goods_class_index_click_asc'] : $lang['goods_class_index_click_desc']; ?>"><?php echo $lang['goods_class_index_click'] ?>
                            <i></i></a></li>
                    <li <?php if ($_GET['key'] == '3'){ ?>class="selected"<?php } ?>><a
                                href="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '3') ? replaceParam(array('key' => '3', 'order' => '1')) : replaceParam(array('key' => '3', 'order' => '2')); ?>"
                                <?php if ($_GET['key'] == '3'){ ?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc'; ?>"<?php } ?>
                                title="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '3') ? $lang['goods_class_index_price_asc'] : $lang['goods_class_index_price_desc']; ?>"><?php echo $lang['goods_class_index_price']; ?>
                            <i></i></a></li>
                </ul>
            </div>
            <div class="nch-sortbar-filter" nc_type="more-filter">
                <span class="arrow"></span>
                <ul>
                    <li><a href="<?php if ($_GET['type'] == 1) {
                            echo dropParam(array('type'));
                        } else {
                            echo replaceParam(array('type' => '1'));
                        } ?>" <?php if ($_GET['type'] == 1) { ?>class="selected"<?php } ?>><i></i>平台自营</a></li>
                    <li><a href="<?php if ($_GET['gift'] == 1) {
                            echo dropParam(array('gift'));
                        } else {
                            echo replaceParam(array('gift' => '1'));
                        } ?>" <?php if ($_GET['gift'] == 1) { ?>class="selected"<?php } ?>><i></i>赠品</a></li>
                    <!-- 消费者保障服务 -->
                    <?php if ($output['contract_item']) { ?>
                        <?php foreach ($output['contract_item'] as $citem_k => $citem_v) { ?>
                            <li><a href="<?php if (in_array($citem_k, $output['search_ci_arr'])) {
                                    echo removeParam(array('ci' => $citem_k));
                                } else {
                                    echo replaceParam(array("ci" => $output['search_ci_str'] . $citem_k));
                                } ?>"
                                   <?php if (in_array($citem_k, $output['search_ci_arr'])) { ?>class="selected"<?php } ?>><i></i><?php echo $citem_v['cti_name']; ?>
                                </a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>

        </nav>
        <!-- 商品列表循环  -->
        <div>
            <?php require_once(BASE_TPL_PATH . '/home/goods.squares.php'); ?>
        </div>
        <div class="tc mt20 mb20">
            <div class="pagination"> <?php echo $output['show_page']; ?> </div>
        </div>
    </div>

    <!-- S 推荐展位 -->
    <div nctype="booth_goods" class="nch-module" style="display:none;"></div>
    <!-- 猜你喜欢 -->
    <div id="guesslike_div"></div>
    <!-- <?php if (!empty($output['viewed_goods'])){ ?>-->
    <!-- 我的足迹 -->
    <div class="nch-module nch-module-style03">
        <div class="title">
            <h3><?php echo $lang['goods_class_viewed_goods']; ?><span><a
                            href="<?php echo SHOP_SITE_URL; ?>/index.php?act=member_goodsbrowse&op=list">全部浏览历史</a></span>
            </h3>
        </div>
        <div class="content">
            <div class="nch-sidebar-viewed">
                <ul>
                    <?php if (!empty($output['viewed_goods']) && is_array($output['viewed_goods'])) { ?>
                        <?php foreach ($output['viewed_goods'] as $k => $v) { ?>
                            <li class="nch-sidebar-bowers">
                                <div class="goods-pic"><a
                                            href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id'])); ?>"
                                            target="_blank"><img
                                                src="<?php echo UPLOAD_SITE_URL; ?>/shop/common/loading.gif" rel="lazy"
                                                data-url="<?php echo thumb($v, 60); ?>"
                                                title="<?php echo $v['goods_name']; ?>"
                                                alt="<?php echo $v['goods_name']; ?>"></a></div>
                                <dl>
                                    <dd><?php echo $lang['currency']; ?><?php echo ncPriceFormat($v['goods_promotion_price']); ?></dd>
                                </dl>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php } ?>
    <!-- E 推荐展位 -->
    <div class="nch-module"><?php echo loadadv(37, 'html'); ?></div>
    <div class="clear"></div>
</div>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/waypoints.js"></script>
<script src="<?php echo SHOP_RESOURCE_SITE_URL; ?>/js/search_category_menu.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/fly/jquery.fly.min.js" charset="utf-8"></script>
<!--[if lt IE 10]>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fly/requestAnimationFrame.js"
        charset="utf-8"></script>
<![endif]-->
<script type="text/javascript" src="http://api.map.baidu.com/getscript?v=2.0&ak=mue30clIcd2lBh90kl8d67YqANBBU28I&services=&t=20180323171755"></script>
<script type="text/javascript">
    var defaultSmallGoodsImage = '<?php echo defaultGoodsImage(240);?>';
    var defaultTinyGoodsImage = '<?php echo defaultGoodsImage(60);?>';

    $(function () {
        $('#files').tree({
            expanded: 'li:lt(2)'
        });
        //品牌索引过长滚条
        $('#ncBrandlist').perfectScrollbar({suppressScrollX: true});
        //浮动导航  waypoints.js
        $('#main-nav-holder').waypoint(function (event, direction) {
            $(this).parent().toggleClass('sticky', direction === "down");
            event.stopPropagation();
        });
        // 单行显示更多
        $('span[nc_type="show"]').click(function () {
            s = $(this).parents('dd').prev().find('li[nc_type="none"]');
            if (s.css('display') == 'none') {
                s.show();
                $(this).html('<i class="icon-angle-up"></i><?php echo $lang['goods_class_index_retract'];?>');
            } else {
                s.hide();
                $(this).html('<i class="icon-angle-down"></i><?php echo $lang['goods_class_index_more'];?>');
            }
        });

        <?php if(isset($_GET['area_id']) && intval($_GET['area_id']) > 0){?>
        // 选择地区后的地区显示
        $('[nc_type="area_name"]').html('<?php echo $output['province_array'][intval($_GET['area_id'])]; ?>');
        <?php }?>

        <?php if(isset($_GET['cate_id']) && intval($_GET['cate_id']) > 0){?>
        // 推荐商品异步显示
        $('div[nctype="booth_goods"]').load('<?php echo urlShop('search', 'get_booth_goods', array('cate_id' => $_GET['cate_id']))?>', function () {
            $(this).show();
        });
        <?php }?>

        //猜你喜欢
        $('#guesslike_div').load('<?php echo urlShop('search', 'get_guesslike', array()); ?>', function () {
            $(this).show();
        });

        //商品分类推荐
        $('#gc_goods_recommend_div').load('<?php echo urlShop('search', 'get_gc_goods_recommend', array('cate_id' => $output['default_classid'])); ?>');

        //获取更多
        $('#more_select_nav a').click(function () {
            var attr = $(this).attr('class');
            if (attr == 'down') {
                $(this).attr('class', 'up');
                $(this).find('i').removeClass('icon-angle-down').addClass('icon-angle-up');
                $(this).find('span').html('收起选项&nbsp;');
                $('.nch-module-filter .hide_dl').show();
            } else {
                $(this).attr('class', 'down');
                $(this).find('i').removeClass('icon-angle-up').addClass('icon-angle-down');
                $(this).find('span').html('更多选项&nbsp;');
                $('.nch-module-filter .hide_dl').hide();
            }
        });
    });


    function myInsert(){
        if(document.getElementsByClassName("sort-box")!=null){
            if (document.getElementsByClassName("sort-box")[0].children[0].text == "酒店") {
                var insertText = '<div style="text-align: left; padding: 20px;"><span>入住日期：</span><input type="date" id="date_start" onchange="setDateCookie()"/><span>退房日期：</span><input type="date" id="date_end" onchange="setDateCookie()"/><button type="button" onclick="SearchClick()">搜索</button></div>';
                document.getElementById("insert").innerHTML = insertText;
                SetTimeInput();
            }
            else if(document.getElementsByClassName("sort-box")[0].children[0].text == "约车"){
                var insertText = '<style type="text/css">#allmap{height:300px;width:100%;}#r-result,#r-result table{width:100%;}#allmap{ z-index:10000;}#wai{padding: 6px;box-shadow: 1px 1px 3px #000;}</style><div id="wai"><div id="allmap"></div></div><div id="driving_way"><span id = "tooltip">总路程为：</span><span id = "tooltip_num">_______</span><span id = "tooltip_after">公里</span><br/>出发地：<input id="start" />目的地：<input id="end" /><select><option value="0">最少时间</option><option value="1">最短距离</option><option value="2">避开高速</option></select><input type="button" id="result" value="查询"/></div>';
                document.getElementById("insert").innerHTML = insertText;
                setDrive();
            }
        }
    }

    myInsert();

    function SearchClick() {
        var data = {};
        data.start = document.getElementById("date_start").value;
        data.end = document.getElementById("date_end").value;
        addCookie("getHotelPrice", JSON.stringify(data));
        location.reload();
    }

    function setDateCookie() {
        var data = {};
        data.start = $('#date_start').val();
        data.end = $('#date_end').val();
        addCookie("getHotelPrice", JSON.stringify(data));
        console.log(getCookie("getHotelPrice"));
        //console.log("setDateCookie");
    }

    function SetTimeInput() {
        function AppendZero(obj) {
            if (obj < 10)
                return "0" + "" + obj;
            else
                return obj;
        }

        if (getCookie("getHotelPrice") == null) {
            var dateObj = new Date();
            var month = dateObj.getUTCMonth() + 1; //months from 1-12
            var day = dateObj.getUTCDate();
            var year = dateObj.getUTCFullYear();
            var newStartDate = year + "-" + AppendZero(month) + "-" + AppendZero(day);

            dateObj.setDate(dateObj.getDate() + 1)
            month = dateObj.getUTCMonth() + 1; //months from 1-12
            day = dateObj.getUTCDate();
            year = dateObj.getUTCFullYear();
            var newEndDate = year + "-" + AppendZero(month) + "-" + AppendZero(day);

            document.getElementById("date_start").value = newStartDate;
            document.getElementById("date_end").value = newEndDate;

        } else if (getCookie("getHotelPrice").split('"')[7] == null) {
            var startDate = getCookie("getHotelPrice").split('"')[3]
            document.getElementById("date_start").value = startDate;
            var dateObj = new Date();
            dateObj.setUTCFullYear(parseInt(startDate.split("-")[0], 10));
            dateObj.setUTCMonth(parseInt(startDate.split("-")[1], 10));
            dateObj.setUTCDate(parseInt(startDate.split("-")[2], 10));
            dateObj.setDate(dateObj.getDate() + 1);
            var month = dateObj.getUTCMonth() + 1; //months from 1-12
            var day = dateObj.getUTCDate();
            var year = dateObj.getUTCFullYear();
            var newEndDate = year + "-" + AppendZero(month) + "-" + AppendZero(day);

            document.getElementById("date_end").value = newEndDate;
        } else {
            document.getElementById("date_start").value = getCookie("getHotelPrice").split('"')[3];
            document.getElementById("date_end").value = getCookie("getHotelPrice").split('"')[7];
        }


    }

    function setDrive() {
        if(getCookie("getLocation")!=null && getCookie("getLocation").split('"')[3]!=null && getCookie("getLocation").split('"')[7]!=null)
        {
            document.getElementById("start").value = getCookie("getLocation").split('"')[3];
            document.getElementById("end").value = getCookie("getLocation").split('"')[7];
        }

        var map = new BMap.Map("allmap");
        var start = document.getElementById("start").value;
        var end = document.getElementById("end").value;
        map.centerAndZoom("青岛", 11);
        map.setCurrentCity("青岛");
        map.enableScrollWheelZoom(true);
        //三种驾车策略：最少时间，最短距离，避开高速
        var routePolicy = [BMAP_DRIVING_POLICY_LEAST_TIME, BMAP_DRIVING_POLICY_LEAST_DISTANCE, BMAP_DRIVING_POLICY_AVOID_HIGHWAYS];
        $("#result").click(function () {
            var start = document.getElementById("start").value;
            var end = document.getElementById("end").value;
            if (start == "" || end == "") {
                alert("输入有误！");
                return;
            }

            var data = {};
            data.start = start;
            data.end = end;
            addCookie("getLocation", JSON.stringify(data));
            console.log(getCookie("getLocation"));

            map.clearOverlays();
            var i = $("#driving_way select").val();
            search(start, end, routePolicy[i]);

            function search(start, end, route) {

                var searchComplete = function (results) {
                    if (driving.getStatus() != BMAP_STATUS_SUCCESS) {
                        return;
                    }
                    var plan = results.getPlan(0); //获取时间
                    output = plan.getDistance(true).slice(0, this.length - 3) + "\n"; //获取距离

                    // $.get('index.php?act=goods&op=calPrice&distance=' + output, function (resp) {
                    //     var str = document.getElementById("tooltip_after").innerText;
                    //     str = str.slice("，")[0] + "里，价格约为" + resp + "元";
                    //     document.getElementById("tooltip_after").innerText = str;
                    // })
                    var str = document.getElementById("tooltip_after").innerText;
                    str = str.slice("，")[0] + "里";
                    document.getElementById("tooltip_after").innerText = str;
                }

                var driving = new BMap.DrivingRoute(map, {
                    renderOptions: {
                        map: map,
                        autoViewport: true
                    },
                    policy: route,
                    onSearchComplete: searchComplete,
                    onPolylinesSet: function () {
                        document.getElementById("tooltip_num").innerText = output;
                    }
                });
                driving.search(start, end);
            }


        });
        var output = "";
    }

    /*function setDriveTime() {
        function AppendZero(obj) {
            if (obj < 10)
                return "0" + "" + obj;
            else
                return obj;
        }

        if (getCookie("getHotelPrice") == null || getCookie("getHotelPrice").split('"')[7] == null) {
            var dateObj = new Date();
            var month = dateObj.getUTCMonth() + 1; //months from 1-12
            var day = dateObj.getUTCDate();
            var year = dateObj.getUTCFullYear();
            var newEndDate = year + "-" + AppendZero(month) + "-" + AppendZero(day);

            document.getElementById("date_end").value = newEndDate;

        } else if (getCookie("getHotelPrice").split('"')[7] != null) {
            document.getElementById("date_end").value = getCookie("getHotelPrice").split('"')[7];
        }
    }*/

</script>


