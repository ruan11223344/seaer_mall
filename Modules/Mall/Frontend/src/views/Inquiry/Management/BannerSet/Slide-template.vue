<template>
    <div class="SlideSet">
        <div class="SlideSet-title">Slide Settings:</div>
        <article class="SlideSet-article">
            <p>Up to 5 slides supported.</p>
            <p>It supports JPG, JPEG, GIF, PNG as file type. The recommended size is 940* 300-440px, less than 1 MB. The slides effect can only be valid
  when you upload more than 2 images.</p>
            <p>Press Submit to view the demo the slides effect when finished uploading.</p>
            <p>Make sure the link of the image is valid.</p>
        </article>
        <div class="SlideSet-banner">
            <Carousel
                v-model="value3"
                :autoplay="setting.autoplay"
                :autoplay-speed="setting.autoplaySpeed"
                :dots="setting.dots"
                :radius-dot="setting.radiusDot"
                :trigger="setting.trigger"
                :arrow="setting.arrow"
                :height="setting.height">
                <CarouselItem>
                    <div class="demo-carousel">1</div>
                </CarouselItem>
                <CarouselItem>
                    <div class="demo-carousel">2</div>
                </CarouselItem>
                <CarouselItem>
                    <div class="demo-carousel">3</div>
                </CarouselItem>
                <CarouselItem>
                    <div class="demo-carousel">4</div>
                </CarouselItem>
            </Carousel>
        </div>
        <hr class="SlideSet-hr">
        <div class="SlideSet-cards">
            <template v-for="item in 5">
                <section class="SlideSet-cards-list">
                    <div class="SlideSet-cards-list-img">
                        <img src="" alt="">
                    </div>
                    <div class="SlideSet-cards-list-title">URL Jump...</div>
                    <div class="SlideSet-cards-list-input">
                        <input type="url">
                    </div>
                    <div class="SlideSet-cards-list-upload">
                        <button type="button">Upload</button>
                        <img :src="require('@/assets/img/icon/shanc.png')" alt="">
                    </div>
                </section>
            </template>
        </div>
        <hr class="SlideSet-hr">

        <div class="SlideSet-save">
            <button type="button">Save</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                value3: 0,
                setting: {
                    autoplay: true,
                    autoplaySpeed: 2000,
                    dots: 'inside',
                    radiusDot: false,
                    trigger: 'click',
                    arrow: 'hover',
                    height: 193
                }
            }
        },
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .SlideSet {

        &-title{
            font-size: 16px;
            color: #333333;
            line-height: 1;
            margin-top: 38px;
        }

        &-article {
            margin-top: 10px;

            & > p {
                font-size: 14px;
                color: #999999;
                padding-left: 15px;
                line-height: 1.4;
                position: relative;
            }

            & > p::before {
                content: '- ';
                font-size: 14px;
                position: absolute;
                left: 0px;
            }
        }

        &-banner {
            width: 741px;
            height: 193px;
            background-color: #f2f6f9;
            margin: 0px auto;
            margin-top: 28px;
        }

        &-hr {
            margin-top: 25px;
            margin-bottom: 20px;
            border-top: 1px solid #eeeeee
        }

        &-cards {
            .flex(space-between, center);

            &-list {
                width: 170px;
                height: 202px;

                &-img {
                    width: 170px;
                    height: 109px;
                    background-color: #f2f6f9;
                }

                &-title {
                    font-size: 14px;
                    line-height: 1;
                    color: #666666;
                    margin-top: 17px;
                }

                &-input {
                    margin-top: 7px;

                    & > input {
                        width: 170px;
                        height: 26px;
                        border: solid 1px #dddddd;
                    }
                }

                &-upload {
                    margin-top: 5px;
                    .flex(flex-start, center);

                    & > button {
                        width: 63px;
                        height: 25px;
                        border: solid 1px #f0883a;
                        background-color: #ffffff;
                        font-size: 12px;
                        color: #f0883a;
                        margin-right: 10px;
                    }

                    & > img {
                        width: 13px;
	                    height: 17px;
                    }
                }
            }
        }

        &-save {
            text-align: center;

            & > button {
                width: 90px;
                height: 34px;
                background-color: #f0883a;
                border: none;
                font-size: 18px;
                color: #ffffff;
                margin-bottom: 20px;
            }
        }
    }
</style>