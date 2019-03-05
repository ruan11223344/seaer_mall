<template>
    <el-main id="main">
        <section class="info">
            <div class="info-left"></div>
            <div class="info-center"></div>
            <div class="info-right"></div>
        </section>

        <section class="chart">
            <div class="chart-title">
                走势图
            </div>

            <div class="chart-box">
                <canvas id="myChart"></canvas>
            </div>
        </section>
    </el-main>
</template>

<script>
    import Chart from "chart.js"

    export default {
        methods: {
            myChart() {
                const ctx = document.getElementById('myChart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'line',
                    // type: 'polarArea',
                    data: {
                        labels: ["2019-2-2", "2019-2-3", "2019-2-4", "2019-2-5", "2019-2-6", "2019-2-7", "2019-8"],
                        datasets: [
                            {
                                label: "新注册用户",
                                backgroundColor: 'rgba(0, 0, 0, 0)',
                                borderColor: '#628fff',
                                data: [3, 103, 544, 222, 203, 301, 4523],
                            },
                            {
                                label: "新增订单",
                                backgroundColor: 'rgba(0, 0, 0, 0)',
                                borderColor: 'rgb(255, 99, 132)',
                                data: [23, 1023, 225, 232, 2330, 2130, 435],
                            },
                            {
                                label: "新增管理员",
                                backgroundColor: 'rgba(0, 0, 0, 0)',
                                borderColor: '#685caf',
                                data: [0, 130, 525, 233, 2420, 3520, 1145],
                            },
                        ],
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: '日期'
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    // labelString: '用户'
                                }
                            }]
                        },
                        animation: {
                            duration: 2000,
                            easing: 'linear'
                        }
                    }
                })
            }
        },
        mounted() {
            this.myChart()
        },
    }
</script>

<style lang="scss" scoped>
    
    #main {
        width: 100%;

        .info {
            height: 185px + 42px * 2;
            @include mixin-flex(space-around, center);

            & > div {
                width: 490px;
                height: 185px;
                border-radius: 10px;
                border: solid 1px #eeeeee;
                margin: 0px 10px;
            }

            &-left {
                background-color: #f7f7fb;
            }

            &-center {
                background-color: #f6faf6;
            }

            &-right {
                background-color: #fbf9f7;
            }
        }

        .chart {
            padding: 0px 15px;

            &-title {
                font-size: 16px;
                padding-bottom: 10px;
                border-bottom: solid 1px #eeeeee;
                @include mixin-color(grey);
            }

            &-box {
                // width: 90%;
                height: 450px;
                margin: 0px auto;
                margin-top: 30px;

                #myChart {
                    max-width: 900px;
                    max-height: 450px;
                    margin: 0px auto;
                }
            }
        }
    }
</style>
