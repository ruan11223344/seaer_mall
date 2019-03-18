<template>
    <el-main id="home" v-loading="homeData == null">
        <section class="info" v-if="homeData">
            <div class="info-left">
                <img :src="require('@/assets/yonghu.png')" alt="" class="info-left-icon">

                <div class="info-left-content">
                    <p class="title">今日注册用户</p>
                    <p class="num">{{ homeData.today_data.today_register }}</p>
                    <p class="title">
                        总注册用户
                        <span class="title-num">{{ homeData.total_data.total_register }}</span>
                    </p>
                </div>
            </div>
            <div class="info-center">
                <img :src="require('@/assets/goutong.png')" alt="" class="info-center-icon">

                <div class="info-center-content">
                    <p class="title">今日询盘量</p>
                    <p class="num">{{ homeData.today_data.today_inquiry }}</p>
                    <p class="title">
                        总注册用户
                        <span class="title-num">{{ homeData.total_data.total_inquiry }}</span>
                    </p>
                </div>
            </div>
            <div class="info-right">
                <img :src="require('@/assets/shangp.png')" alt="" class="info-right-icon">

                <div class="info-right-content">
                    <p class="title">今日上架商品</p>
                    <p class="num">{{ homeData.today_data.today_product }}</p>
                    <p class="title">
                        总注册用户
                        <span class="title-num">{{ homeData.total_data.total_product }}</span>
                    </p>
                </div>
            </div>
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
        data() {
            return {
                homeData: null
            }
        },
        methods: {
            myChart(data) {
                const user = Object.keys(data.new_user)
                const userData = []

                for(let item in data.new_user) {
                    userData.push(data.new_user[item])
                }

                const adminData = []

                for(let item in data.new_admin_count) {
                    adminData.push(data.new_admin_count[item])
                }

                const inquiryData = []

                for(let item in data.new_inquiry) {
                    inquiryData.push(data.new_inquiry[item])
                }

                const ctx = document.getElementById('myChart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: user,
                        datasets: [
                            {
                                label: "新注册用户",
                                backgroundColor: 'rgba(0, 0, 0, 0)',
                                borderColor: '#628fff',
                                data: userData,
                            },
                            {
                                label: "新增询盘",
                                backgroundColor: 'rgba(0, 0, 0, 0)',
                                borderColor: 'rgb(255, 99, 132)',
                                data: inquiryData,
                            },
                            {
                                label: "新增管理员",
                                backgroundColor: 'rgba(0, 0, 0, 0)',
                                borderColor: '#685caf',
                                data: adminData,
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
                                }
                            }]
                        },
                        animation: {
                            duration: 2000,
                            easing: 'linear'
                        }
                    }
                })
            },
        },
        created() {
            this.$GetRequest.getHomeData()
                .then(res => {
                    this.homeData = res
                    console.log(res)
                    this.myChart(res.seven_day_data)
                })
                .catch(err => {
                    this.$message.error(err.message)
                })
        },
        mounted() {
            
        },
    }
</script>

<style lang="scss" scoped>
    @mixin mixin-info {
        &-content {

            .title {
                font-size: 18px;
                color: #999999;

                &-num {
                    display: inline-block;
                    font-size: 18px;
                    color: #666666;
                    margin-left: 35px;
                }
            }

            & > .num {
                font-size: 32px;
                color: #f0883a;
                margin-top: 19px;
                margin-bottom: 28px;
            }
        }
    }

    @mixin mixin-info-before {
        content: '';
        width: 7px;
        height: 100%;
        border-radius: 5px 0px 0px 5px;
        position: absolute;
        top: 0px;
        left: 0px;
    }

    #home {
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
                position: relative;
            }

            &-left {

                background-color: #f7f7fb;
                @include mixin-info;
                @include mixin-flex(flex-start, center);

                &::before {
                    @include mixin-info-before;
                    background-color: #9c99dc;
                }

                &-icon {
                    width: 92px;
                    height: 74px;
                    display: block;
                    margin-left: 36px;
                    margin-right: 42px;
                }
            }

            &-center {
                background-color: #f6faf6;
                @include mixin-info;
                @include mixin-flex(flex-start, center);

                &::before {
                    @include mixin-info-before;
                    background-color: #7dcb78;
                }

                &-icon {
                    width: 81px;
	                height: 80px;
                    display: block;
                    margin-left: 43px;
                    margin-right: 46px;
                }
            }

            &-right {
                background-color: #fbf9f7;
                @include mixin-info;
                @include mixin-flex(flex-start, center);

                &::before {
                    @include mixin-info-before;
                    background-color: #ff9d00;
                }

                &-icon {
                    width: 68px;
	                height: 72px;
                    display: block;
                    margin-left: 45px;
                    margin-right: 57px;
                }
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
