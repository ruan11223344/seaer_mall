<template>
    <div class="PicturePreview">
        <v-title title="Manage Photos"></v-title>

        <!-- 切换 -->
        <section class="PicturePreview-screening">
            <router-link to="/inquiryList/Album/administration" class="PicturePreview-screening-text">My Album</router-link>
            <div class="PicturePreview-screening-hr"></div>
            <div class="PicturePreview-screening-text PicturePreview-screening-text-active">Detailed Picture</div>
        </section>

        <section class="PicturePreview-title">
            <v-img width="63" height="50" imgSrc="" style="border: 1px solid #ccc;"></v-img>
            <div class="PicturePreview-title-right">
                <div>Default Album</div>
                <div>Description Description Description Description Description</div>
            </div>
        </section>

        <!-- 轮播 -->
        <section class="PicturePreview-Carousel">
            <swiper :options="swiperOption" ref="swiperOption">
                <swiper-slide v-for="item in 20" :key="item">
                    <div style="width: 72px;height: 74px;background-color: #ffffff;border: solid 1px #eeeeee;">
                        {{item}}
                    </div>
                </swiper-slide>
            </swiper>
            <div class="PicturePreview-Carousel-prev" >
                <Icon type="ios-arrow-back" size="25"/>
            </div>
            <div class="PicturePreview-Carousel-next" >
                <Icon type="ios-arrow-forward" size="25"/>
            </div>
        </section>
        <!-- 商品信息预览 -->
        <section class="PicturePreview-info">
            <div class="PicturePreview-info-left">

            </div>
            <div class="PicturePreview-info-right">
                <div style="marginTop: 10px;">
                    <div class="PicturePreview-info-right-title">Picture Name</div>
                    <ul>
                        <li class="PicturePreview-info-right-list">55_05959334847243862</li>
                    </ul>
                </div>
                <div style="marginTop: 40px;">
                    <div class="PicturePreview-info-right-title">Picture Name</div>
                    <ul>
                        <li class="PicturePreview-info-right-list">Upload Time: 2019-01-23</li>
                        <li class="PicturePreview-info-right-list">Album Name: Default Album</li>
                        <li class="PicturePreview-info-right-list">Image Size: 31.25KB</li>
                        <li class="PicturePreview-info-right-list">Image Size: 150x150</li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    import Title from "../../components/Title"
    import 'swiper/dist/css/swiper.css'

    import { swiper, swiperSlide } from 'vue-awesome-swiper'

    export default {
        data() {
            return {
                swiperOption: {
                    slidesPerView: 10,
                    spaceBetween: 12,
                    slidesPerGroup: 1,
                    loop: false,
                    loopFillGroupWithBlank: true,
                    navigation: {
                        nextEl: '.PicturePreview-Carousel-next',
                        prevEl: '.PicturePreview-Carousel-prev'
                    }
                }
            }
        },
        methods: {
            onPrev() {
            }
        },
        mounted() {
           
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            swiper,
            swiperSlide
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .PicturePreview {
        .width(945px, auto);
        min-height: 772px;
        .bg-color(white);
        padding: 21px 30px;

        &-screening {
            .width(885px, 47px);
            background-color: #f5f5f9;
            margin: 20px 0px;
            .flex(flex-start, center);
            padding-left: 27px;

            &-text {
                .lineHeight(47px);
                font-size: 14px;
                color: #666666;

                & > span {
                    color: #d72b2b;
                }
                cursor: pointer;
            }
            &-text-active {
                border-bottom: 2px solid #f0883a;
            }

            &-hr {
                width: 1px;
                height: 11px;
                background-color: #cccccc;
                margin: 0px 18px;
            }
        }
        
        &-title {
            .flex();

            &-right {
                margin-left: 18px;
                .flex(center, flex-start);
                flex-direction: column;

                & > div {
                    line-height: 1;
                }

                & > div:first-child {
                    font-size: 14px;
                    color: #666666;
                    margin-bottom: 13px;
                }

                & > div:last-child {
                    font-size: 12px;
                    color: #999999;
                }
            }
        }

        &-Carousel {
            width: 885px;
            height: 96px;
            background-color: #f5f5f9;
            margin-top: 10px;
            margin-bottom: 12px;
            position: relative;
            padding: 0px 25px;
            .flex(flex-start, center);

            &-prev, &-next {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                z-index: 100;
                cursor: pointer;
                outline: none;
                
            }

            &-prev {
                left: 0px;
            }

            &-next {
                right: 0px;
            }
        }

        &-info {
            height: 559px;
            .flex(space-between);

            &-left {
                width: 544px;
                height: 559px;
                background-color: #ffffff;
                border: solid 1px #eeeeee;
            }

            &-right {
                width: 885px - 544px - 23px;
                height: 559px;
                overflow: hidden;

                &-title {
                    font-size: 16px;
                    color: #666666;
                    line-height: 1;
                }

                &-list {
                    font-size: 14px;
                    color: #999999;
                    line-height: 1;
                    margin-top: 11px;
                }
            }
        }
    }
</style>