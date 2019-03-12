<template>
    <div class="details">
        <section class="state">
            商品状态 <span class="state-wait">等待审核</span>
        </section>

        <section class="company">
            <div class="title">公司信息</div>
            <article class="company-block">
                <div class="company-block-type">
                    业务类型：<span>贸易公司</span>
                </div>
                <div class="company-block-name">
                    <p>公司名称：<span>Wuhan Sier International Co.,LTD.</span></p>
                    <p>公司中文名称：<span>武汉思迩电子商务有限公司</span></p>
                </div>
                <div class="company-block-address">
                    <p>国家：<span>中国</span></p>
                    <p>省/市：<span>湖北武汉</span></p>
                    <p>地址：<span>东湖高新技术开发区光谷三路777号A座605室</span></p>
                </div>
                <div class="company-block-contact">
                    <p>电话：<span>+86 027-65520870</span></p>
                    <p>网站：<span>https：//www.seaer.com.cn</span></p>
                </div>
            </article>
        </section>

       <section class="business">
            <div class="title">商业信息</div>
            <article class="business-block">
                <div class="business-block-range">
                    <p>经营范围：<span>农业和食品</span></p>

                </div>

                <div class="business-block-product">
                    <p>主营产品：<span>大蒜，苹果</span></p>
                </div>

                <div class="business-block-brief">
                    <p>公司简介：<span>我们在非洲拥有十年的本地销售经验。从事S2B，B2B，B2C和O2O等跨境电子商务业务。 其经营产品涵盖建材，家具，家居用品，汽摩配件，服装，鞋包，3C，IT数码，家电，电脑，电子产品，美容假发，化妆品，母婴用品，工艺品，日用品，玩具，文具，体育用品，运动户外用品，珠宝，电动车及其配件，实现“买世界，卖世界”，为不同国家的买家和卖家提供一站式服务管家服务。</span></p>
                </div>

                <div class="business-block-license">
                    <p>营业执照：<span>91420100MA4KXE9Q0A</span></p>
                </div>

                <div class="business-block-enclosure">
                    <p>附件：</p>
                    <div></div>
                </div>
            </article>
        </section>

        <section class="commodity">
            <div class="title">商品信息</div>
            <article class="commodity-block">
                <div class="commodity-block-type">
                    <p>产品类别：<span>农业 > 食品</span></p>
                </div>

                <div class="commodity-block-name">
                    <p>产品名称：<span>Pure white garlic wholesale</span></p>
                </div>

                <div class="commodity-block-num">
                    <p>SKU编号：<span>kfehffeijg524514</span></p>
                </div>

                <div class="commodity-block-word">
                    <p>关键词：<span>食品-食品-食品</span></p>
                </div>

                <div class="commodity-block-img">
                    <p>产品图片</p>
                    <div></div>
                </div>

                <div class="commodity-block-word">
                    <p>产品属性：<span>Color-red、Color-red、Color-red</span></p>
                </div>

                <div class="commodity-block-price">
                    <p>价格：<span>Ladder Price</span></p>
                    <div>
                        <p>≥10 KSh 10-100</p>
                        <p>≥10 KSh 10-100</p>
                        <p>≥10 KSh 10-100</p>
                    </div>
                </div>

                <div class="commodity-block-details">
                    <p>商品详情</p>
                    <div class="commodity-block-details-box">
                        <swiper :options="swiperOption" style="height: 608px;overflow: hidden;zIndex: 0">
                            <swiper-slide style="height: auto;">
                                <div v-for="(item, index) in 100" :key="index"> {{ item }}</div>
                            </swiper-slide>
                            <div class="swiper-scrollbar" slot="scrollbar"></div>
                        </swiper>
                    </div>
                </div>

                <div class="commodity-block-word">
                    <p>店铺所属类别：<span>食品-食品-食品</span></p>
                </div>

                <div class="commodity-block-word">
                    <p>发布时间：<span>2017-10-10 12:20</span></p>
                </div>
            </article>
        </section>
    </div>
</template>

<script>
/*组件方式引用*/
    import { swiper, swiperSlide } from 'vue-awesome-swiper'
    import 'swiper/dist/css/swiper.css'

    export default {
        data() {
            return {
                swiperOption: {
                    direction: 'vertical',
                    slidesPerView: 'auto',
                    freeMode: true,
                    scrollbar: {
                        el: '.swiper-scrollbar',
                        hide: false, //滚动条是否自动隐藏。默认：false，不会自动隐藏。
                        draggable: true, //该参数设置为true时允许拖动滚动条。
                        snapOnRelease: true, //如果设置为false，释放滚动条时slide不会自动贴合。
                        dragSize: 30, //设置滚动条指示的尺寸。默认'auto': 自动，或者设置num(px)。
                    },
                    mousewheel: true
                }
            }
        },
        components: {
            swiper,
            swiperSlide
        }
    }
</script>

<style lang="scss" scoped>

    @mixin title {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 12px;
        @include mixin-color(grey);
    }

    @mixin article {
        font-size: 14px;
        font-weight: normal;
        font-stretch: normal;
        @include mixin-color(grey);
        flex-wrap: wrap;

        & > p {
            margin-right: 40px;

            // & > span {
                // font-size: 16px;
            // }
        }
    }

    .details {
        padding: 33px 40px;
        line-height: 1;

        .state {
            @include title;
            font-weight: normal;
            margin-bottom: 34px;

            &-wait {
                margin-left: 12px;
                @include mixin-color(yellow);
            }
        }

        .company {
            .title {
                @include title;
            }

            &-block {
                width: 100%;
                height: auto;
                padding: 20px 30px;
                margin-bottom: 22px;
                line-height: 2.5;
                box-sizing: border-box;
                @include mixin-bg-color(lead);

                &-type {
                    @include article;
                }

                &-name, &-address, &-contact {
                    @include article;
                    @include mixin-flex(flex-start, center);
                }
            }
        }

        .business {
            .title {
                @include title;
            }

            &-block {
                width: 100%;
                height: auto;
                padding: 20px 30px;
                margin-bottom: 22px;
                line-height: 2.5;
                box-sizing: border-box;
                @include mixin-bg-color(lead);

                &-range, &-product, &-brief, &-license  {
                    @include article;
                }

                &-enclosure {
                    @include article;
                    @include mixin-flex(flex-start, flex-start);

                    & > div {
                        width: 85px;
                        height: 84px;
                        background-color: #e2e6e8;
                    }
                }
            }
        }

        .commodity {
            .title {
                @include title;
            }

            &-block {
                padding: 10px 0px;
                height: auto;
                margin-bottom: 0;
                line-height: 2.5;
                box-sizing: border-box;

                &-type, &-name, &-num, &-word, &-price {
                    @include article;
                }

                &-img {
                    margin-top: 5px;
                    margin-bottom: 5px;
                    @include article;
                    @include mixin-flex(flex-start, flex-start);

                    & > div {
                        width: 104px;
                        height: 104px;
                        background-color: #f0f1f5;
                    }
                }

                &-price {
                    height: auto;
                    @include mixin-flex(flex-start, flex-start);
                }

                &-details {
                    font-size: 14px;
                    margin-bottom: 10px;
                    @include mixin-color(grey);

                    &-box {
                        height: 608px;
                        // overflow: hidden;
                        position: relative;
                        background-color: #f5f5f9;
                    }
                }
            }
        }
    }
</style>