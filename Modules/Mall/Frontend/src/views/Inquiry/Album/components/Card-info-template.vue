<template>
    <div class="cardInfo" @mouseleave="onLeave" @mouseover="onOver">
        <template>
            <v-img width="174" height="180" imgSrc=""></v-img>
        </template>
        <template>
            <div class="cardInfo-info cardInfo-body">
                <div class="cardInfo-info-block">
                    <div class="cardInfo-info-block-title">Default Album</div>
                    <div>
                        <img :src="require('@/assets/img/icon/bianj.png')" alt="" :style="{ width: '17px', height: '16px' }">
                    </div>
                </div>
                
                <template v-if="bool">
                    <div class="cardInfo-body-block">
                        Upload time: 2019-01-01
                    </div>
                    <div class="cardInfo-body-block">
                        Originai size: 800x800
                    </div>
                </template>
                

                <template v-else>
                    <div class="cardInfo-info-block">
                        <div class="cardInfo-info-block-content">
                            <img :src="require('@/assets/img/icon/shagnc.png')" alt="" :style="{ width: '8px', height: '10px' }">
                            <span class="cardInfo-info-block-content-span">Replace</span>
                        </div>
                        <div class="cardInfo-info-block-content">
                            <img :src="require('@/assets/img/icon/shanc.png')" alt="" :style="{ width: '9px', height: '12px' }">
                            <span class="cardInfo-info-block-content-span">Delete</span>
                        </div>
                    </div>
                    <div class="cardInfo-info-block">
                        <div class="cardInfo-info-block-content" style="width: 153px;">
                            <img :src="require('@/assets/img/icon/yidong.png')" alt="" :style="{ width: '9px', height: '12px' }">
                            <span class="cardInfo-info-block-content-span">Move to other album</span>
                        </div>
                    </div>
                    <div class="cardInfo-info-block">
                        <div class="cardInfo-info-block-content" style="width: 153px;">
                            <img :src="require('@/assets/img/icon/tupian.png')" alt="" :style="{ width: '9px', height: '12px' }">
                            <span class="cardInfo-info-block-content-span">set cover</span>
                        </div>
                    </div>
                    <div class="cardInfo-info-block">
                        <div class="cardInfo-info-block-content" style="width: 153px;">
                            <img :src="require('@/assets/img/icon/wenb.png')" alt="" :style="{ width: '9px', height: '12px' }">
                            <span class="cardInfo-info-block-content-span">copy the picture's url</span>
                        </div>
                    </div>
                </template>
            </div>
        </template>

        <!-- 右上角按钮 -->
        <div class="cardInfo-top">
            <Checkbox v-model="single"></Checkbox>
        </div>
    </div>
</template>

<script>
    import Img from "@/components/Img"

    export default {
        data() {
            return {
                single: false,
                bool: true,
                clear: null
            }
        },
        methods: {
            onLeave() {
                clearTimeout(this.clear)
                this.clear = setTimeout(() => {
                    this.bool=true
                }, 400)
            },
            onOver() {
                clearTimeout(this.clear)
                this.clear = setTimeout(() => {
                    this.bool=false
                }, 400)
            }
        },
        components: {
            "v-img": Img,
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
        z-index: 1;

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
