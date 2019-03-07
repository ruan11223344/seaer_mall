<template>
    <div class="PicturePreview">
        <v-title title="Manage Photos"></v-title>

        <!-- 切换 -->
        <v-table-switch title="My Album" :num="num" :tableSwitch="['Detailed Picture']" style="marginBottom: 20px;" @on-click="onTableSwitch"></v-table-switch>

        <section class="PicturePreview-title">
            <v-img width="63" height="50" :imgSrc="require('@/assets/img/wenjianj.png')"></v-img>
            <div class="PicturePreview-title-right">
                <div>{{ ActiveData.AlbumName }}</div>
                <div>{{ ActiveData.description != "null" ? ActiveData.description : '' }}</div>
            </div>
        </section>

        <!-- 轮播 -->
        <section class="PicturePreview-Carousel">
            <swiper :options="swiperOption" ref="swiperOption" style="width: 885px;">
                <!-- 渲染 -->
                <swiper-slide v-for="(item, index) in FormData" :key="index">
                    <div
                        class="PicturePreview-Carousel-list"
                        :class="ActiveData.id == item.id ? 'PicturePreview-Carousel-active' : ''"
                        @click="onClcik(item)">
                        <img :src="item.photo_url" alt="" style="width: 100%; height: 100%;cursor: pointer;">
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
                <img :src="ActiveData.url" alt="" style="width: 100%; height: 100%;cursor: pointer;">
            </div>
            <div class="PicturePreview-info-right">
                <div style="marginTop: 10px;">
                    <div class="PicturePreview-info-right-title">Picture Name</div>
                    <ul>
                        <li class="PicturePreview-info-right-list">{{ ActiveData.photoName }}</li>
                    </ul>
                </div>
                <div style="marginTop: 40px;">
                    <div class="PicturePreview-info-right-title">Picture Name</div>
                    <ul>
                        <!-- <li class="PicturePreview-info-right-list">Upload Time: 2019-01-23</li>
                        <li class="PicturePreview-info-right-list">Album Name: Default Album</li>
                        <li class="PicturePreview-info-right-list">Image Size: 31.25KB</li>
                        <li class="PicturePreview-info-right-list">Image Size: 150x150</li> -->
                        <li class="PicturePreview-info-right-list">Upload Time: {{ ActiveData.Time }}</li>
                        <li class="PicturePreview-info-right-list">Album Name: {{ ActiveData.AlbumName }}</li>
                        <li class="PicturePreview-info-right-list">Image Size: {{ parseInt(info.FileSize.value / 1024) + 'KB' }}</li>
                        <li class="PicturePreview-info-right-list">Image Size: {{ info.ImageWidth.value  + ' x ' + info.ImageHeight.value }}</li>
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
    // 切换
    import TableSwitch from "../../components/TableSwitch/index.vue"
    import { swiper, swiperSlide } from 'vue-awesome-swiper'

    export default {
        data() {
            return {
                num: 1,
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
                },
                FormData: [],
                ActiveData: '',
                info: {
                    FileSize: {
                        value: ''
                    },
                    Format: {
                        value: ''
                    },
                    ImageWidth: {
                        value: ''
                    },
                    ImageHeight: {
                        value: ''
                    }
                }
            }
        },
        methods: {
            // 切换
            onTableSwitch(num) {
                this.num = num
                switch (num) {
                    case 0:
                        this.$router.push('/inquiryList/Album/administration')
                        break
                    case 1:
                        
                        break
                }
            },
            onClcik(item) {
                this.ActiveData = {
                    photoName: item.photo_name,
                    Time: item.created_at,
                    AlbumName: this.$route.query.name,
                    url: item.photo_url,
                    Path: item.photo_path,
                    description: this.$route.query.description,
                    AlbumId: this.$route.query.album_id,
                    id: item.id
                }
                this.onGetImgInfo(item.photo_path)
            },
            onGetImgInfo(image_path) {
                this.$request({
                    url: '/album/get_img_info',
                    method: 'get',
                    params: {
                        image_path: image_path
                    }
                }).then(res => {
                    this.info = res
                })
            },
            // 获取
            onGetAlbumList() {
                this.$request(
                    {
                        url: '/album/album_photo_list',
                        method: 'get',
                        params: {
                            album_id: this.$route.query.album_id
                        }
                    }
                ).then(res => {
                    if(res.code == 200) {
                        this.FormData = res.data
                    }
                }).catch(err => {
                    return false
                })
            },
            onPrev() {
            }
        },
        created() {
            this.onGetAlbumList()
        },
        mounted() {
            this.ActiveData = {
                photoName: this.$route.query.photo_name,
                Time: this.$route.query.created_at,
                AlbumName: this.$route.query.name,
                url: this.$route.query.photo_url,
                Path: this.$route.query.photo_path,
                description: this.$route.query.description,
                AlbumId: this.$route.query.album_id,
                id: this.$route.query.id
            }

            this.onGetImgInfo(this.$route.query.photo_path)
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-table-switch": TableSwitch,
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
            z-index: 0;
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

            &-list {
                width: 72px;
                height: 74px;
                background-color: #ffffff;
                // border: solid 1px #eeeeee;
                border: solid 2px transparent;
                transition: 0.3s all;
            }

            &-list:hover {
                border: solid 2px red;
            }
            
            &-active {
                border: solid 2px red;
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