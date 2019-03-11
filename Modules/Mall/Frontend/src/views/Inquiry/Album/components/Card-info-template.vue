<template>
    <div>
        <div class="cardInfo" @mouseleave="onLeave" @mouseover="onOver">
            <template>
                <!-- <span @click="$router.push({ path:'/inquiryList/Album/PicturePreview', query:{ item, NodeAlbum:$route.query }})"> -->
                <span @click="$router.push({ path:'/inquiryList/Album/PicturePreview', query:{ 
                        album_id: item.album_id,
                        created_at: item.created_at,
                        id: item.id,
                        photo_name: item.photo_name,
                        photo_path: item.photo_path,
                        photo_url: item.photo_url,
                        description: $route.query.description,
                        name: $route.query.name
                }})">
                    <!-- <v-img  :imgSrc="item.photo_url"></v-img> -->
                    <img :src="item.photo_url" style="width: 174px; height:180px" alt="">
                </span>
            </template>
            <template>
                <div class="cardInfo-info cardInfo-body">
                    <div class="cardInfo-info-block">
                        <div class="cardInfo-info-block-title">{{ $route.query.name }}</div>
                        <!-- <div>
                            <img :src="require('@/assets/img/icon/bianj.png')" alt="" :style="{ width: '17px', height: '16px' }">
                        </div> -->
                    </div>
                    
                    <template v-if="bool">
                        <div class="cardInfo-body-block">
                            {{ item.created_at }}
                        </div>
                        <div class="cardInfo-body-block">
                            Originai size: {{ item.photo_size }}
                        </div>
                    </template>

                    <template v-else>
                        <div class="cardInfo-info-block">
                            <!-- 替换图片暂时不要 -->
                            <!-- <div class="cardInfo-info-block-content">
                                <img :src="require('@/assets/img/icon/shagnc.png')" alt="" :style="{ width: '8px', height: '10px' }">
                                <span class="cardInfo-info-block-content-span">Replace</span>
                            </div> -->
                            <div class="cardInfo-info-block-content" style="width: 153px;">
                                <img :src="require('@/assets/img/icon/shanc.png')" alt="" :style="{ width: '9px', height: '12px' }">
                                <span class="cardInfo-info-block-content-span" @click="deletAlbum=true">Delete</span>
                            </div>
                        </div>
                        <div class="cardInfo-info-block">
                            <div class="cardInfo-info-block-content" style="width: 153px;">
                                <img :src="require('@/assets/img/icon/yidong.png')" alt="" :style="{ width: '9px', height: '12px' }">
                                <span class="cardInfo-info-block-content-span" @click="moveAlbum=true">Move to other album</span>
                            </div>
                        </div>
                        <div class="cardInfo-info-block">
                            <div class="cardInfo-info-block-content" style="width: 153px;">
                                <img :src="require('@/assets/img/icon/wenb.png')" alt="" :style="{ width: '9px', height: '12px' }">
                                <span class="cardInfo-info-block-content-span"
                                v-clipboard:copy="item.photo_url"
                                v-clipboard:success="onCopy"
                                v-clipboard:error="onError"
                                >copy the picture's url</span>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
            <!-- 右上角按钮 -->
            <div class="cardInfo-top" @click="onChange">
                <Checkbox v-model="item.single"></Checkbox>
            </div>
        </div>

        <v-deletealbum :dataId="[item.id]" v-show="deletAlbum" @on-show="onDeleteShow"></v-deletealbum>

        <!-- 移动到其他相册操作 -->
        <template>
            <v-move-other-albums :dataId="[item.id]" v-show="moveAlbum" @on-show="onMoveAlbum"></v-move-other-albums>
        </template>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    // 移动到其他相册操作
    import MoveOtherAlbums from '../MoveOtherAlbums/index.vue'
    // 删除功能
    import DeletAlbum from "../DeleteAlbum/index.vue"
    import getData from '@/utils/getData.js'

    export default {
        data() {
            return {
                bool: true,
                clear: null,
                deletAlbum: false,
                moveAlbum: false,
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
        props: {
            item: {
                type: Object
            }
        },
        methods: {
            onGetImgInfo(image_path) {
                // this.$request({
                //     url: '/album/get_img_info',
                //     method: 'get',
                //     params: {
                //         image_path: image_path
                //     }
                // }).then(res => {
                //     this.info = res
                // })
            },
            onCopy() {
                this.$Message.info('Success copy')
            },
            onError() {
                this.$Message.error('Copy failure')
            },
            onDeleteShow(bool) {
                this.deletAlbum = false
                if(bool) {
                    this.$emit('on-getData')
                }
            },
            onMoveAlbum(bool) {
                this.moveAlbum = false
                if(bool) {
                    this.$emit('on-getData')
                }
            },
            onLeave() {
                clearTimeout(this.clear)
                this.clear = setTimeout(() => {
                    this.bool = true
                }, 400)
            },
            onOver() {
                clearTimeout(this.clear)
                this.clear = setTimeout(() => {
                    this.bool=false
                }, 400)
            },
            onChange() {
                this.item.single = !this.item.single
                this.$emit('on-changes')
            }
        },
        mounted() {
            // this.onGetImgInfo(this.item.photo_path)
        },
        components: {
            "v-img": Img,
            "v-deletealbum": DeletAlbum,
            "v-move-other-albums": MoveOtherAlbums,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .cardInfo {
        width: 174px;
        height: 180px + 72px;
        background-color: #ffffff;
        border: solid 1px #eeeeee;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        z-index: 0;

        &-info {
            width: 173px;
            height: 72px;
            background-color: #f5f5f9;
            border: solid 1px #eeeeee;
            position: absolute;
            left: 0px;
            bottom: 0px;
            padding: 5px 9px;
            animation: mylast 0.8s;


            &-block {
                .flex(space-between, center);
                margin-bottom: 5px;

                &-title {
                    font-size: 14px;
                    color: #666666;
                }

                &-content {
                    height: 18px;;
                    .flex(flex-start, center);
                    background-color: #ffffff;
                    padding: 4px 8px;

                    &-span {
                        margin-left: 5px;
                        font-size: 12px;
                        line-height: 1;
                        color: #999999;
                    }
                }
            }
        }

        &-body {
            &-block {
                .flex(space-between, center);
                margin-bottom: 5px;

                &-title {
                    font-size: 14px;
                    color: #666666;
                }
            }

            &-block {
                font-size: 12px;
                line-height: 1;
                color: #999999;
                margin-bottom: 6px;
            }
        }

        &-top {
            position: absolute;
            top: 9px;
            left: 9px;
        }
    }

    .cardInfo:hover {

        .cardInfo-info {
            display: block;
            height: 127px;
            animation: myfirst 0.8s;
        }
    }

    @keyframes myfirst {
        0% {
            height: 72px;
            padding: 5px 9px;
        }

        50% {
            height: 0px;
            bottom: -15px;
        }

        100% {
            height: 127px;
            padding: 5px 9px;
        }
    }

    @keyframes mylast {
        0% {
            height: 127px;
            padding: 5px 9px;
        }

        50% {
            height: 0px;
            bottom: -15px;
        }

        100% {
            height: 72px;
            padding: 5px 9px;
        }
    }
</style>
