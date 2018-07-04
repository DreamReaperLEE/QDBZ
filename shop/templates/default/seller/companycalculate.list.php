<?php defined('In33hao') or exit('Access Invalid!');?>

<div class="wrap">
<!--    <div class="tabmenu">-->
<!--        --><?php //include template('layout/submenu');?>
<!--    </div>-->


    <div id="main" style="width: 600px;height:400px;"></div>
    <a href="javascript:void(0)"style="    font-weight: 600;
    line-height: 28px;width: 100px;
    color: #3BAEDA;
    background-color: #FFF;
    padding: 10px 40px;
    margin: 0;
    border-style: solid;
    border-color: #3BAEDA;
    border-width: 1px;box-shadow: 2px 2px 4px 1px #cccccc" onclick=switch1()> 切换</a>
</div>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" ></script>
<script type="text/javascript">
    $(function(){
        $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
        $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<script src="<?php echo RESOURCE_SITE_URL;?>/echarts.common.min.js" ></script>

<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

        var json = <?php echo $output['json']; ?>;
        var arr = [];
        var arr2 = [];
        var arr3 = [];
        for(var x in json) {
            var obj = {};
            if(x == 'hotel') {
                obj['name'] = '酒店';
                arr2.push('酒店');
            } else if(x == 'meeting'){
                obj['name'] = '会议';
                arr2.push('会议');
            }
            else if(x == 'eating'){
                obj['name'] = '餐饮';
                arr2.push('餐饮');
            }else if(x == 'car'){
                obj['name'] = '约车';
                arr2.push('约车');
            }
            obj['value'] = json[x];
            arr.push(obj);
            arr3.push(json[x]);
        }

        // 指定图表的配置项和数据
        var option = {

            title : {
                text: '服务订单统计',
                subtext: '',
                x:'center'
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
            tooltip : {
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
            series : [
                {
                    name: '姓名',
                    type: 'pie',
                    radius : '55%',
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
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            tooltip : {
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
            if(flag) {
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
