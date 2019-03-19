<template>
    <div class="details">
        <section class="state">
            商品状态 <span class="state-wait">等待审核</span>
        </section>

        <template v-if="company_info != null">
            <section class="company">
                <div class="title">公司信息</div>
                <article class="company-block">
                    <div class="company-block-type">
                        业务类型：<span>{{ company_info.company_business_type_str }}</span>
                    </div>
                    <div class="company-block-name">
                        <p>公司名称：<span>{{ company_info.company_name }}</span></p>
                        <p>公司中文名称：<span>{{ company_info.company_name_in_china }}</span></p>
                    </div>
                    <div class="company-block-address">
                        <p>国家：<span>{{ company_info.company_country == 'China' ? '中国' : '肯尼亚' }}</span></p>
                        <p>省/市：<span>{{ company_info['province/city'] }}</span></p>
                        <p>地址：<span>{{ company_info.company_detailed_address }}</span></p>
                    </div>
                    <div class="company-block-contact">
                        <p>电话：<span>{{ company_info.company_mobile_phone }}</span></p>
                        <p>网站：<span>{{ company_info.company_website }}</span></p>
                    </div>
                </article>
            </section>
        </template>

        <template v-if="company_info != null">
            <section class="business">
                <div class="title">商业信息</div>
                <article class="business-block">
                    <div class="business-block-range">
                        <p>经营范围：<span>{{ company_info.company_business_range_ids_str }}</span></p>

                    </div>

                    <div class="business-block-product">
                        <p>主营产品：<span>{{ company_info.company_main_products }}</span></p>
                    </div>

                    <div class="business-block-brief">
                        <p>公司简介：<span>{{ company_info.company_profile }}</span></p>
                    </div>

                    <div class="business-block-license">
                        <p>营业执照：<span>{{ company_info.company_business_license }}</span></p>
                    </div>

                    <div class="business-block-enclosure">
                        <p>附件：</p>
                        <div>
                            <img :src="company_info.company_business_license_pic_url" alt="" style="width: 100%;height: 100%; display: block;cursor: pointer;" @click="openGallery([ company_info.company_business_license_pic_url ], 0)">
                        </div>
                    </div>
                </article>
            </section>
        </template>

        <template v-if="product_info != null">
            <section class="commodity">
                <div class="title">商品信息</div>
                <article class="commodity-block">
                    <div class="commodity-block-type">
                        <p>产品类别：<span>{{ product_info.product_categories_str }}</span></p>
                    </div>

                    <div class="commodity-block-name">
                        <p>产品名称：<span>{{ product_info.product_name }}</span></p>
                    </div>

                    <div class="commodity-block-num">
                        <p>SKU编号：<span>{{ product_info.product_sku_no }}</span></p>
                    </div>

                    <div class="commodity-block-word">
                        <p>关键词：<span>{{ product_info.product_keywords_str }}</span></p>
                    </div>

                    <div class="commodity-block-img">
                        <p>产品图片</p>
                        <div v-for="(item, index) in product_info.product_images_url" :key="index">
                            <img :src="item" alt="" style="width: 100%; height: 100%; cursor: pointer;" @click="openGallery(product_info.product_images_url, index)">
                        </div>
                    </div>

                    <div class="commodity-block-word">
                        <p>产品属性：<span>{{ product_info.product_attr_str }}</span></p>
                    </div>

                    <div class="commodity-block-price">
                        <p>价格：<span>{{ product_info.product_price_type }} Price</span></p>
                        <div>
                            <p v-for="(item, index) in product_info.product_price_str_arr" :key="index">
                                {{ item }}
                            </p>
                        </div>
                    </div>

                    <div class="commodity-block-details" v-if="product_info.product_details">
                        <p>商品详情</p>
                        <div class="commodity-block-details-box">
                            <swiper :options="swiperOption" style="height: 608px;overflow: hidden;zIndex: 0">
                                <swiper-slide style="height: auto;">
                                    <div v-html="product_info.product_details"></div>
                                </swiper-slide>
                                <div class="swiper-scrollbar" slot="scrollbar"></div>
                            </swiper>
                        </div>
                    </div>

                    <!-- <div class="commodity-block-word">
                        <p>店铺所属类别：<span>食品-食品-食品</span></p>
                    </div> -->

                    <div class="commodity-block-word">
                        <p v-if="product_publish_time">发布时间：<span>{{ product_publish_time }}</span></p>
                    </div>
                </article>
            </section>
        </template>

        <LightBox
            :images="images"
            ref="lightbox"
            :show-caption="false"
            :show-light-box="false"
            >
        </LightBox>
    </div>
</template>

<script>
    /*组件方式引用*/
    import { swiper, swiperSlide } from 'vue-awesome-swiper'
    import 'swiper/dist/css/swiper.css'

    import 'quill/dist/quill.bubble.css'
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import LightBox from 'vue-image-lightbox'
    import 'vue-image-lightbox/dist/vue-image-lightbox.min.css'

    export default {
        beforeRouteEnter(to, from, next) {
            next(that => {
                that.$GetRequest.getProductInfo(to.query.product_id)
                    .then(res => {
                        that.company_info = res.company_info
                        that.product_info = res.product_info
                        that.product_publish_time = res.product_publish_time
                    })
                    .catch(err => {
                        that.$message.error(err.message)
                    })
            })
        },
        data() {
            return {
                swiperOption: {
                    direction: 'vertical',
                    slidesPerView: 'auto',
                    freeMode: true,
                    scrollbar: {
                        el: '.swiper-scrollbar',
                        hide: false,
                        draggable: true,
                        snapOnRelease: true,
                        dragSize: 30,
                    },
                    mousewheel: true
                },
                company_info: null,
                product_info: null,
                product_publish_time: null,
                images: []
            }
        },
        methods: {
            openGallery(data, index) {
                this.images = []
                for (let index = 0; index < data.length; index++) {
                    this.$set(this.images, index, {
                        thumb: data[index],
                        src: data[index]
                    })
                }

                this.$refs.lightbox.showImage(index)
            }
        },
        mounted() {
        },
        components: {
            swiper,
            swiperSlide,
            LightBox
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
                        margin-right: 10px;
                        cursor: pointer;
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