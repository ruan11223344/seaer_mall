<template>
    <div class="SlideSet">
        <div class="SlideSet-title">Slide Settings:</div>
        <article class="SlideSet-article">
            <p>Up to 5 slides supported.</p>
            <p>It supports JPG, JPEG, GIF, PNG as file type. The recommended size is 1920*500px, less than 1 MB. The slides effect can only be valid
  when you upload more than 2 images.</p>
            <p>Press Submit to view the demo the slides effect when finished uploading.</p>
            <p>Make sure the link of the image is valid.</p>
        </article>
        <div class="SlideSet-banner">
            <template v-if="slideLists.length">
                <Carousel
                    :loop="true"
                    :autoplay="setting.autoplay"
                    :autoplay-speed="setting.autoplaySpeed"
                    :dots="setting.dots"
                    :radius-dot="setting.radiusDot"
                    :trigger="setting.trigger"
                    :arrow="setting.arrow"
                    :height="setting.height">
                        <CarouselItem v-if="slideLists.length > 0">
                            <img style="width: 741px; height: 193px; display: block;" :src="slideLists[0].url" alt="">
                        </CarouselItem>

                        <CarouselItem v-if="slideLists.length > 1">
                            <img style="width: 741px; height: 193px; display: block;" :src="slideLists[1].url" alt="">
                        </CarouselItem>

                        <CarouselItem v-if="slideLists.length > 2">
                            <img style="width: 741px; height: 193px; display: block;" :src="slideLists[2].url" alt="">
                        </CarouselItem>

                        <CarouselItem v-if="slideLists.length > 3">
                            <img style="width: 741px; height: 193px; display: block;" :src="slideLists[3].url" alt="">
                        </CarouselItem>
                        
                        <CarouselItem v-if="slideLists.length > 4">
                            <img style="width: 741px; height: 193px; display: block;" :src="slideLists[4].url" alt="">
                        </CarouselItem>
                </Carousel>
            </template>
        </div>
        <hr class="SlideSet-hr">
        <div class="SlideSet-cards">
            <template v-for="(item, index) in slideData">
                <section class="SlideSet-cards-list" :key="index">
                    <img class="SlideSet-cards-list-img" :src="item.img_url" alt="">
                    <div class="SlideSet-cards-list-title">URL Jump...</div>
                    <div class="SlideSet-cards-list-input">
                        <input type="url" v-model="item.img_jump">
                    </div>
                    <div class="SlideSet-cards-list-upload">
                        <Upload
                            action="//jsonplaceholder.typicode.com/posts/"
                            style="display: inline-block;"
                            :before-upload="onUpload"
                            :show-upload-list="false"
                            >
                            <button type="button" class="SlideSet-cards-list-upload-button" @click="onClick(index)">Upload</button>
                        </Upload>
                        <img :src="require('@/assets/img/icon/shanc.png')" alt="" @click="onDel(index)">
                    </div>
                </section>
            </template>
        </div>
        <hr class="SlideSet-hr">

        <div class="SlideSet-save">
            <button type="button" @click="onSave">Save</button>
        </div>

        <v-cropper :url="url" :autoCropWidth="1920" :autoCropHeight="500" @on-cropper="onCropper" @on-show="onShow" v-show="show"></v-cropper>
    </div>
</template>

<script>
    // 裁剪
    import Cropper from "@/components/Cropper"
    import upData from "@/utils/upData.js"
    import getData from "@/utils/getData.js"

    import { swiper, swiperSlide } from 'vue-awesome-swiper'
    import 'swiper/dist/css/swiper.css'

    export default {
        data() {
            return {
                setting: {
                    autoplay: true,
                    autoplaySpeed: 2000,
                    dots: 'inside',
                    radiusDot: false,
                    trigger: 'click',
                    arrow: 'hover',
                    height: 193
                },
                url: '',
                show: false,
                num: 1,
                slideData: [
                    {
                        img_url: '',
                        img_path: '',
                        img_jump: '',
                    },
                    {
                        img_url: '',
                        img_path: '',
                        img_jump: ''
                    },
                    {
                        img_url: '',
                        img_path: '',
                        img_jump: ''
                    },
                    {
                        img_url: '',
                        img_path: '',
                        img_jump: ''
                    },
                    {
                        img_url: '',
                        img_path: '',
                        img_jump: ''
                    }
                ],
                slideLists: [],
                index: -1
            }
        },
        methods: {
            upSlides: upData.upSlides,
            upSetSlides: upData.upSetSlides,
            onGetSlidesList: getData.onGetSlidesList,
            getObjectURL: getData.getObjectURL,
            // 截图
            onCropper(data) {
                this.upSlides(data).then(async res => {
                    if(res.code == 200) {
                        await this.$set(this.slideData, this.index , res.data)
                    }
                })
            },
            onClick(i) {
                this.index = i
            },
            // 删除
            onDel(index) {
                this.$set(this.slideData, index, {
                    img_url: '',
                    img_path: '',
                    img_jump: ''
                })
            },
            // 阻止默认上传
            onUpload(file) {
                this.url = this.getObjectURL(file)

                this.show = true

                return false
            },
            onShow(bool) {
                this.show = bool
            },
            onSave() {
                this.slideLists = []
                const slides = this.slideData
                const arr = []
                
                slides.forEach((value, index) => {
                    if(value.img_path != '' && value.img_path != '' && value.img_jump != '') {
                        arr.push({ sort: index + 1, url_path: value.img_path, url_jump: value.img_jump })
                    }
                })

                this.upSetSlides(arr).then(res => {
                    res.code == 200 ? this.$Message.info(res.message) : this.$Message.error(res.message)
                    this.onGetSlidesList().then(res => {
                        this.slideLists = res
                    })
                })
            }
        },
        created() {
            this.onGetSlidesList().then(res => {
                this.slideLists = res
                for(let { sort, url, url_path, url_jump } of res) {
                    this.$set(this.slideData, sort - 1, {
                        img_url: url,
                        img_path: url_path,
                        img_jump: url_jump
                    })
                }
            })
        },
        mounted() {
            
        },
        components: {
            "v-cropper": Cropper,
            swiper,
            swiperSlide
        }
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

            &-list {
                display: inline-block;
                width: 741px !important;
                height: 193px;

                &-img {
                    width: 741px;
                    height: 193px;
                    background-size: 100% 100% !important;
                }
            }
        }
        
        &-hr {
            margin-top: 25px;
            margin-bottom: 20px;
            border-top: 1px solid #eeeeee
        }

        &-cards {
            .flex(flex-start, center);

            &-list {
                width: 170px;
                height: 202px;
                margin-right: (885px - 170px * 5) / 4;

                &-img {
                    width: 170px;
                    height: 109px;
                    background-color: #f2f6f9;
                    display: block;
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

                    &-button {
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
                        cursor: pointer;
                    }
                }
            }
        }

        &-list:last-child {
            margin-right: 0px;
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