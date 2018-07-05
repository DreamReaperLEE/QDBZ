<?php //defined('In33hao') or exit('Access Invalid!');?>
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: Administrator-->
<!-- * Date: 2018/3/30 0030-->
<!-- * Time: 17:23-->
<!-- */-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <title>zx1984, Calendar-Price-jQuery</title>
    <link rel="stylesheet" href="<?php echo RESOURCE_SITE_URL;?>/calendar-price-jquery-master/dist/css/calendar-price-jquery.min.css">
    <style>
        body {margin: 0; padding: 0; font-family: "Microsoft YaHei UI";}
    </style>
</head>
<body>

<div class="container"></div>
<input readonly type="hidden" name = 'common_id' value="<?php echo $output['common_id'] ?>"/><a methods="post" href="/shop/index.php?act=hotel&op=save_hotel"></a>
<script src="<?php echo RESOURCE_SITE_URL;?>/calendar-price-jquery-master/demo/js/jquery-1.12.4.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/calendar-price-jquery-master/demo/js/mock-data.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/calendar-price-jquery-master//dist/js/calendar-price-jquery.min.js"></script>
<?php //echo $output['hotel'] ?>
<!--<script src="../src/js/calendar-price-jquery.js"></script>-->

<script>


    $(function () {
        // 传入数据
        var MOCK_DATA = <?=$output['hotel']?>;
        var common_id = <?=$output['common_id']?>;



        var zxCalendar = $.CalendarPrice({
            el: '.container',
            // startDate: '2017-08-02',
            endDate: '2019-12-20',
            data: MOCK_DATA,
            // 配置需要设置的字段名称
            config: [
                {
                    key: 'hotel_baseprice',
                    name: '房间基础价'
                },
                {
                    key: 'hotel_plusprice',
                    name: '房间加价'
                }

            ],
            // 配置在日历中要显示的字段
            show: [
                {
                    key: 'hotel_baseprice',
                    name: '基:￥'
                },
                {
                    key: 'hotel_plusprice',
                    name: '加:￥'
                }

            ],
            callback: function (data) {
                // log('callback ....');
                // log(data);

                console.log(data)
                $.ajax({
                    type: 'post', //post方式
                    async: false, //是否异步，默认为true
                    url: "/shop/index.php?act=hotel&op=save_hotel", //发送的接收地址。
                    data: {data:data,common_id:common_id}, //参数
                    error: function (xhr) { //如果发生错误，在这里处理或提示
                    },
                    success: function (str) {
                        console.log("后台接受到的是")
                        console.log(str)
                        // location.href="/"
                    },
                    // dataType: "text" //返回结果的类型。

                });
                window.location.href="/shop/index.php?act=store_goods_online&op=index";

                },
            cancel: function () {
                log('取消设置 ....');
                // 取消设置
                // 这里可以触发关闭设置窗口
                // ...
            },
            monthChange: function (month) {
                log('monthChange: ')
                log(month)
//        var newData = createMockData()
//        zxCalendar.update(newData)
            },
            reset: function () {
                log('数据重置成功！');
            },
            error: function (err) {
                console.error(err.msg);
                alert(err.msg);
            },
            // 自定义颜色
            style: {
                // 头部背景色
                headerBgColor: '#098cc2',
                // 头部文字颜色
                headerTextColor: '#fff',
                // 周一至周日背景色，及文字颜色
                weekBgColor: '#098cc2',
                weekTextColor: '#fff',
                // 周末背景色，及文字颜色
                weekendBgColor: '#098cc2',
                weekendTextColor: '#fff',
                // 有效日期颜色
                validDateTextColor: '#333',
                validDateBgColor: '#fff',
                validDateBorderColor: '#eee',
                // Hover
                validDateHoverBgColor: '#098cc2',
                validDateHoverTextColor: '#fff',
                // 无效日期颜色
                invalidDateTextColor: '#ccc',
                invalidDateBgColor: '#fff',
                invalidDateBorderColor: '#eee',
                // 底部背景颜色
                footerBgColor: '#fff',
                // 重置按钮颜色
                resetBtnBgColor: '#77c351',
                resetBtnTextColor: '#fff',
                resetBtnHoverBgColor: '#55b526',
                resetBtnHoverTextColor: '#fff',
                // 确定按钮
                confirmBtnBgColor: '#098cc2',
                confirmBtnTextColor: '#fff',
                confirmBtnHoverBgColor: '#00649a',
                confirmBtnHoverTextColor: '#fff',
                // 取消按钮
                cancelBtnBgColor: '#fff',
                cancelBtnBorderColor: '#bbb',
                cancelBtnTextColor: '#999',
                cancelBtnHoverBgColor: '#fff',
                cancelBtnHoverBorderColor: '#bbb',
                cancelBtnHoverTextColor: '#666'
            }
            // 点击有效的某一触发的回调函数
            // 注意：配置了此参数，设置窗口无效，即不能针对日期做参数设置
            // 返回每天的数据
//        everyday: function (dayData) {
//            console.log('点击某日，返回当天的数据');
//            console.log(dayData);
//        },
            // 隐藏底部按钮（重置、确定、取消），前台使用该插件时，则需要隐藏底部按钮
//        hideFooterButton: true
        });
        log(zxCalendar)
    });

    function log (s) {
        console.log(s)
    }
</script>
<script>
    function () {
        $.get(
            "http://172.16.0.162/shop/index.php?act=test&op=time",
            function(res){console.lgo(res.startDate)},'json');
    }
</script>
</body>
</html>
