<template>
    <div class="SlideSet">
        <div class="SlideSet-title">Slide Settings:</div>
        <article class="SlideSet-article">
            <p>Up to 5 slides supported.</p>
            <p>It supports JPG, JPEG, GIF, PNG as file type. The recommended size is 940*440px, less than 1 MB. The slides effect can only be valid
  when you upload more than 2 images.</p>
            <p>Press Submit to view the demo the slides effect when finished uploading.</p>
            <p>Make sure the link of the image is valid.</p>
        </article>
        <div class="SlideSet-banner" v-if="slideLists.length">
            <Carousel
                :loop="true"
                :autoplay="setting.autoplay"
                :autoplay-speed="setting.autoplaySpeed"
                :dots="setting.dots"
                :radius-dot="setting.radiusDot"
                :trigger="setting.trigger"
                :arrow="setting.arrow"
                :height="setting.height">
                <template v-for="(item, index) in slideLists">
                    <CarouselItem :key="index">
                        <img style="width: 741px; height: 193px; display: block;" :src="item.url" alt="">
                    </CarouselItem>
                </template>
            </Carousel>
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
                            <button type="button" class="SlideSet-cards-list-upload-button">Upload</button>
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
        <v-cropper :url="url" :autoCropWidth="940" :autoCropHeight="440" @on-cropper="onCropper" @on-show="onShow" v-show="show"></v-cropper>
        
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
                    
                ],
                slideLists: []
            }
        },
        methods: {
            upSlides: upData.upSlides,
            upSetSlides: upData.upSetSlides,
            onGetSlidesList: getData.onGetSlidesList,
            getObjectURL: getData.getObjectURL,
            // 截图
            onCropper(data) {
                const len = this.slideData.length

                this.upSlides(data).then(async res => {
                    if(res.code == 200) {
                        // 世界上最遥远的距离if else
                        if(len < 5){
                            await this.$set(this.slideData, len - 1 ,res.data)
                            await this.slideData.push({
                                img_url: '',
                                img_path: '',
                                img_jump: ''
                            })
                        }else {
                            if(len < 6 && this.slideData[4].img_url == '') {
                                this.$set(this.slideData, 4 ,res.data)
                            }
                        }
                    }
                })
            },
            // 删除
            onDel(index) {
                this.slideData.length > 0 ? this.$delete(this.slideData, index) : false

                this.slideData.length == 0 ? this.slideData.push({
                    img_url: '',
                    img_path: '',
                    img_jump: ''
                }) : false
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
                if(this.slideData.length > 0 && this.slideData[0].img_url != '' && this.slideData[0].img_jump != '' ) {
                    const slides = this.slideData
                    const arr = []

                    slides.forEach((value, index) => {
                        if(value.img_path != '' && value.img_url != '' && value.img_jump != '') {
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
            }
        },
        created() {
            this.onGetSlidesList().then(res => {
                this.slideLists = res
                // if(res.length) {
                //     for(let i = 0; i < res.length; i++) {
                //         this.slideData.push({ img_url: res[i].url, img_jump: res[i].url_path })
                //     }

                // }else { 
                //     this.slideData.push({ img_url: '', img_jump: '' })
                // }
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