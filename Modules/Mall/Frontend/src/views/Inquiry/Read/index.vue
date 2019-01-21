<template>
    <div class="read-main">
        <section class="read-main-btn">
            <button>Return</button>
            <button class="read-main-btn-active">Reply</button>
            <button>Delete</button>
            <button>Spam</button>
        </section>
        <!-- 商品信息 -->
        <section class="read-main-card">
            <div class="read-main-card-date">
                <div class="read-main-card-date-time">
                    <span>Time:</span>
                    <span class="read-main-card-date-time-text">Dec,28  2018  13:21</span>
                </div>
                <div class="read-main-card-date-address">
                    <span>IP Address:</span>
                    <span  class="read-main-card-date-address-text">
                        <v-img width="26" height="17" :imgSrc="require('@/assets/img/china.png')" class="read-main-card-date-address-text-ip"></v-img>
                        <span>27.59.221.*</span>
                    </span>
                </div>
            </div>
            <div class="read-main-card-from">
                <span>From:</span>
                <span>
                    <span class="read-main-card-from-text">Charles Wang</span>
                    <v-img width="26" height="17" :imgSrc="require('@/assets/img/china.png')"></v-img>
                </span>
            </div>
            <div class="read-main-card-subject">
                <span>Subject:</span>
                <span>Inquiry about “High Quality New Crop/Fresh Garlic - Chinese Shandong Garlic”</span>
            </div>
            <div class="read-main-card-figure">
                <v-img width="64" height="64" :imgSrc="require('@/assets/img/china.png')"></v-img>
                <div class="read-main-card-figure-parameter">
                    <p>Purchase Quantity:10 Bays</p>
                    <p>Extra Request:Price,Company Profile</p>
                </div>
            </div>
        </section>
        <!-- 询问信息 -->
        <section class="read-main-info" v-html="'Hello,\rI need high quality fabric,I need high quality fabricI need high quality fabric I need high quality fabric'">

        </section>

        <section class="read-main-up">
            <div class="read-main-up-title">
                <v-img width="13" height="13" :imgSrc="require('@/assets/img/fj.png')"></v-img>
                <div class="read-main-up-title-file">Attached  <span>({{ 2 }} pieces)</span></div>
            </div>
            <ul class="read-main-up-item">
                <li>
                    <v-img width="12" hegiht="12" imgSrc=""></v-img>
                    <span>{{ 'attachment1.rar (17.2k)' }}</span>
                </li>
                <li>
                    <v-img width="12" hegiht="12" imgSrc=""></v-img>
                    <span>{{ 'attachment1.rar (17.2k)' }}</span>
                </li>
            </ul>
        </section>
    </div>
</template>

<script>
    import Img from '@/components/Img'
    export default {
        components: {
            'v-img': Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .read-main {
        .width(945px, auto);
        .bg-color(white);
        padding-top: 15px;
        align-self: flex-start;

        &-btn {
            margin-bottom: 16px;
            padding-left: 16px;

            & > button {
                border: none;
                width: 66px;
                height: 25px;
                background-color: #fff8f3;
                border: solid 1px #f0883a;
                font-size: 14px;
                line-height: 25px;
                color: #f0883a;
                margin-right: 13px;
            }

            & > &-active {
                background-color: #f0883a;
                color: #ffffff;
            }
        }

        &-card {
            width: 100%;
            height: 184px;
            background-color: #e9e9ed;
            padding-top: 10px;
            padding-left: 16px;

            &-date {
                .flex();
                margin-bottom: 10px;

                &-time, &-address {
                    font-size: 14px;
                    line-height: 15.5px;
                    color: #333333;
                    margin-right: 50px;
                    .flex();

                    &-text {
                        font-size: 14px;
                        color: #666666;
                        margin-left: 8px;
                        .flex();

                        &-ip {
                            position: relative;
                            top: -2px;
                        }
                        & > span:last-of-type {
                            margin-left: 8px;
                        }
                    }
                }
            }

            &-from, &-subject {
                font-size: 14px;
                line-height: 1;
                color: #333333;
                .flex();
                margin-bottom: 30px;

                & > span:last-of-type {
                    .flex();
                    color: #666666;
                    margin-left: 8px;
                    margin-right: 13px;
                }

                &-text {
                    margin-right: 13px;
                }
            }

            &-subject {
                margin-bottom: 15px;
            }

            &-figure {
                .flex();

                & > &-parameter {
                    .flex(center, flex-start, column);
                    margin-left: 18px;
                    font-size: 14px;
                    line-height: 1;
                    color: #666666;

                    & > p:first-of-type {
                        margin-bottom: 11px;
                    }
                }
            }
        }

        &-info {
            width: 943px;
            height: 102px;
            background-color: #ffffff;
            padding: 28px 22px;
            font-size: 14px;
            line-height: 2;
            color: #666666;
        }

        &-up {
            width: 100%;
            height: auto;
            background-color: #ffffff;
            border-top: 20px solid #f5f5f9;

            &-title {
                .flex(flex-start, center);
                height: 38px;
                background-color: #e9e9ed;
                padding-left: 20px;
                
                &-file {
                    cursor: pointer;
                    font-size: 16px;
                    line-height: 1;
                    color: #666666;

                    & > span {
                        color: #f0883a;
                    }
                }
            }

            &-item {
                padding: 20px 39px;

                & > li {
                    .flex();
                    & > span:last-of-type {
                        font-size: 14px;
                        line-height: 2;
                        color: #999999;
                        margin-left: 6px;
                    }
                }
            }
        }
    }
</style>