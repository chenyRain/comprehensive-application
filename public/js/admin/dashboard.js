layui.use(['layer','jquery'], function(){
    var layer 	= layui.layer;
    var $=layui.jquery;
    //图表
    var myChart;
    require.config({
        paths: {
            echarts: './js/admin/lib/echarts'
        }
    });
    require(
        [
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line',
            'echarts/chart/map'
        ],
        function (ec) {
            //--- 折柱 ---
            myChart = ec.init(document.getElementById('chart'));
            myChart.setOption(
                {
                    title: {
                        text: "数据统计",
                        textStyle: {
                            color: "rgb(85, 85, 85)",
                            fontSize: 18,
                            fontStyle: "normal",
                            fontWeight: "normal"
                        }
                    },
                    tooltip: {
                        trigger: "axis"
                    },
                    legend: {
                        data: ["会员", "文章", "评论"],
                        selectedMode: false,
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            dataView: {
                                show: false,
                                readOnly: true
                            },
                            magicType: {
                                show: false,
                                type: ["line", "bar", "stack", "tiled"]
                            },
                            restore: {
                                show: true
                            },
                            saveAsImage: {
                                show: true
                            },
                            mark: {
                                show: false
                            }
                        }
                    },
                    calculable: false,
                    xAxis: [
                        {
                            type: "category",
                            boundaryGap: false,
                            data: ["周一", "周二", "周三", "周四", "周五", "周六", "周日"]
                        }
                    ],
                    yAxis: [
                        {
                            type: "value"
                        }
                    ],
                    grid: {
                        x2: 30,
                        x: 50
                    },
                    series: [
                        {
                            name: "会员",
                            type: "line",
                            smooth: true,
                            itemStyle: {
                                normal: {
                                    areaStyle: {
                                        type: "default"
                                    }
                                }
                            },
                            data: [10, 12, 21, 54, 260, 830, 710]
                        },
                        {
                            name: "文章",
                            type: "line",
                            smooth: true,
                            itemStyle: {
                                normal: {
                                    areaStyle: {
                                        type: "default"
                                    }
                                }
                            },
                            data: [30, 182, 434, 791, 390, 30, 10]
                        },
                        {
                            name: "评论",
                            type: "line",
                            smooth: true,
                            itemStyle: {
                                normal: {
                                    areaStyle: {
                                        type: "default"
                                    },
                                    color: "rgb(110, 211, 199)"
                                }
                            },
                            data: [1320, 1132, 601, 234, 120, 90, 20]
                        }
                    ]
                }
            );
        }
    );
    $(window).resize(function(){
        myChart.resize();
    })
});