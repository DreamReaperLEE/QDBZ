<?php defined('In33hao') or exit('Access Invalid!'); ?>

<div class="ncsc-index">
    <div class="top-container">
        <div class="basic-info">
            <dl class="ncsc-seller-info">
                <dt class="seller-name">
                    <h3><?php echo $_SESSION['seller_name']; ?></h3>
                    <h5>(用户名：<?php echo $_SESSION['member_name']; ?>)

<!--                        --><?php //if ($output['store_info']['is_distribution'] == 0) {
//                            if ($output['distribution_info']) {
//                                ?>
<!--                                <b style=" background:#4FC0E8;padding:5px; color:#fff;">分销功能审核中</b>-->
<!--                            --><?php //} else {
//                                echo '<a href="index.php?act=seller_center&op=distribution" style=" background:#48CFAE;padding:5px; color:#fff;">申请开通分销</a>';
//                            }
//                        } else {
//                            echo '<b style=" background:#b1191a;padding:5px; color:#fff;">分销店铺</b>';
//                        } ?>

                    </h5>
                </dt>
                <dd class="store-logo">
                    <p><img src="<?php echo getStoreLogo($output['store_info']['store_label'], 'store_logo'); ?>"/></p>
                   </dd>
                <dd class="seller-permission">管理权限：<strong><?php echo $_SESSION['seller_group_name']; ?></strong></dd>
                <dd class="seller-last-login">最后登录：<strong><?php echo $_SESSION['seller_last_login_time']; ?></strong>

                </dd>
                <dd class="store-name"><?php echo '单位名称' . $lang['nc_colon']; ?><a
                            href="<?php echo urlShop('show_store', 'index', array('store_id' => $_SESSION['store_id']), $output['store_info']['store_domain']); ?>"><?php echo $output['store_info']['store_name']; ?></a>
                </dd>
                <dd class="store-grade"><?php echo '单位等级' . $lang['nc_colon']; ?>
                    <strong><?php echo $output['store_info']['grade_name']; ?></strong></dd>
                <dd class="store-validity"><?php echo $lang['store_validity'] . $lang['nc_colon']; ?>
                    <strong><?php echo $output['store_info']['store_end_time_text']; ?>
                        <?php if ($output['store_info']['reopen_tip']) { ?>
                            <a href="index.php?act=store_info&op=reopen">马上续签</a>
                        <?php } ?>
                    </strong></dd>
            </dl>

        </div>
    </div>
    <div class="seller-cont">


        <div class="container type-b">
            <div class="hd">
                <h3>系统公告</h3>
                <h5></h5>
            </div>
            <div class="content">
                <ul>
                    <?php
                    if (is_array($output['article_list']) && !empty($output['article_list'])) {
                        foreach ($output['article_list'] as $val) {
                            ?>
                            <li><a target="_blank" <?php if ($val['article_url'] != ''){ ?>target="_blank"<?php } ?>
                                   href="<?php if ($val['article_url'] != '') echo $val['article_url']; else echo urlMember('article', 'show', array('article_id' => $val['article_id'])); ?>"
                                   title="<?php echo $val['article_title']; ?>">
                                    <?php echo $val['article_title']; ?></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
                <dl>
                    <dt><?php echo $lang['store_site_info']; ?></dt>
                    <?php
                    if (is_array($output['phone_array']) && !empty($output['phone_array'])) {
                        foreach ($output['phone_array'] as $key => $val) {
                            ?>
                            <dd><?php echo $lang['store_site_phone'] . ($key + 1) . $lang['nc_colon']; ?><?php echo $val; ?></dd>
                            <?php
                        }
                    }
                    ?>
                    <dd><?php echo $lang['store_site_email'] . $lang['nc_colon']; ?><?php echo C('site_email'); ?></dd>
                </dl>
            </div>
        </div>

        <div class="container type-c">
            <div class="hd">
                <h3>员工情况统计</h3>
                <h5>统计员工的订单量和订单金额</h5>
            </div>
            <div class="content">
                <table class="ncsc-default-table">
                    <thead>
                    <tr>
                        <th class="w50">员工</th>
                        <th>账号组</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($output['seller_list']) && is_array($output['seller_list'])) { ?>
                        <?php foreach ($output['seller_list'] as $key => $value) { ?>
                            <tr class="bd-line">
                                <td><?php echo $value['seller_name']; ?></td>
                                <td><?php echo $output['seller_group_array'][$value['seller_group_id']]['group_name']; ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="20" class="norecord">
                                <div class="warning-option"><i
                                            class="icon-warning-sign"></i><span><?php echo $lang['no_record']; ?></span>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container123"">
            <div id="main" style="width: 600px;height:400px;margin-left:auto;margin-right:auto;"></div>
            <div  style="width: 100px;float :right;">
                <input type="button" value="切换" style="
            font-weight: 600;
            line-height: 28px;width: 100px;
            color: #3BAEDA;
            background-color: #FFF;
            padding: 10px 40px;
            margin: 0;
            border-style: solid;
            border-color: #3BAEDA;
            border-width: 1px;box-shadow: 2px 2px 4px 1px #cccccc"
                       onclick=switch1()>
            </div>
        </div>

    </div>
</div>
<script>
    $(function () {
        var timestamp = Math.round(new Date().getTime() / 1000 / 60);
        $.getJSON('index.php?act=seller_center&op=statistics&rand=' + timestamp, null, function (data) {
            if (data == null) return false;
            for (var a in data) {
                if (data[a] != 'undefined' && data[a] != 0) {
                    var tmp = '';
                    if (a != 'goodscount' && a != 'imagecount') {
                        $('#nc_' + a).parents('a').addClass('num');
                    }
                    $('#nc_' + a).html(data[a]);
                }
            }
        });
    });
</script>

<script charset="utf-8" type="text/javascript"
        src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/sns.js"></script>
<script type="text/javascript">
    $(function () {
        $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
        $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/echarts.common.min.js"></script>

<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    var json = <?php echo $output['json']; ?>;
    var arr = [];
    var arr2 = [];
    var arr3 = [];
    for (var x in json) {
        var obj = {};
        obj['name'] = x;
        obj['value'] = json[x];
        arr.push(obj);
        arr2.push(x);
        arr3.push(json[x]);
    }

    // 指定图表的配置项和数据
    var option = {

        title: {
            text: '项目订单统计',
            subtext: '',
            x: 'center'
        },
        toolbox: {
            show: true,
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},
                saveAsImage: {}
            }
        },
        tooltip: {
            trigger: 'item',
            formatter: "【{b}】  <br/>消费额：{c} <br/>(占比：{d}%)"
        },
        legend: {
            type: 'scroll',
            orient: 'vertical',
            right: 10,
            top: 20,
            bottom: 20,
            data: arr2,

        },
        series: [
            {
                name: '姓名',
                type: 'pie',
                radius: '55%',
                center: ['40%', '50%'],
                data: arr,
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };

    var option2 = {
        color: ['#3398DB'],
        tooltip: {
            trigger: 'axis',
            axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        tooltip: {
            trigger: 'item',
            formatter: "【{b}】  <br/>消费额：{c} <br/>"
        },
        xAxis: {
            type: 'category',
            data: arr2
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: arr3,
            type: 'bar'
        }]
    };


    console.log(arr2);

    // 使用刚指定的配置项和数据显示图表。
    var flag = true;

    function switch1() {
        if (flag) {
            myChart.setOption(option2);
            flag = !flag;
        } else {
            myChart.setOption(option);
            flag = !flag;
        }
    }

    myChart.setOption(option);
    console.log("设置完了")

</script>