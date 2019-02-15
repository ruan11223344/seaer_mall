<template>
    <div class="albumlist">
        <v-title title="Manage Photos"></v-title>

        <!-- 切换 -->
        <section class="albumlist-screening">
            <router-link to="/inquiryList/Album/administration" class="albumlist-screening-text">My Album</router-link>
            <div class="albumlist-screening-hr"></div>
            <div class="albumlist-screening-text albumlist-screening-text-active">List of Image</div>
        </section>

        <section class="albumlist-title">
            <v-img width="63" height="50" imgSrc="" style="border: 1px solid #ccc;"></v-img>
            <div class="albumlist-title-right">
                <div>Default Album</div>
                <div>Description Description Description Description Description</div>
            </div>
        </section>

        <!-- 按钮集合 -->
        <section class="albumlist-buttonAggregate">
            <div class="albumlist-buttonAggregate-left">
                <Checkbox v-model="single"></Checkbox>
                <button type="button" class="albumlist-buttonAggregate-left-btn">Cancel</button>
                <button type="button" class="albumlist-buttonAggregate-left-btn" @click="deletAlbum=true">Delete</button>
                <button type="button" class="albumlist-buttonAggregate-left-btn">Move to other ablum</button>
            </div>
            <div class="albumlist-buttonAggregate-right">
                <span class="albumlist-buttonAggregate-right-sort">Sort by</span>
                <Select v-model="model1" style="width:200px" placeholder="Descending date">
                    <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                </Select>
            </div>
        </section>

        <!-- 提示 -->
        <section class="albumlist-Tips">
            When use 'Replace' function, please make sure you upload the same image format.
        </section>

        <!-- 图片 -->
        <template>
            <div style="marginTop: 13px;" class="albumlist-card">
                <v-card-info v-for="item in 10" :key="item" class="albumlist-card-list"></v-card-info>
            </div>
        </template>

        <template>
            <v-deletealbum v-show="deletAlbum" @on-show="onShow"></v-deletealbum>
        </template>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    import Title from "../../components/Title"
    // 商品组件
    import CardInfoTemplateVue from '../components/Card-info-template.vue'
    // 删除功能
    import DeletAlbum from "../DeleteAlbum/index.vue"

    export default {
        data() {
            return {
                createShow: false,
                uploadShow: false,
                cityList: [
                    {
                        value: 'New York',
                        label: 'New York'
                    },
                    {
                        value: 'London',
                        label: 'London'
                    },
                    {
                        value: 'Sydney',
                        label: 'Sydney'
                    },
                    {
                        value: 'Ottawa',
                        label: 'Ottawa'
                    },
                    {
                        value: 'Paris',
                        label: 'Paris'
                    },
                    {
                        value: 'Canberra',
                        label: 'Canberra'
                    }
                ],
                model1: '',
                single: false,
                deletAlbum: false
            }
        },
        methods: {
            onShow() {
                this.deletAlbum = false
            }
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-card-info": CardInfoTemplateVue,
            "v-deletealbum": DeletAlbum
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .albumlist {
        .width(945px, auto);
        min-height: 772px;
        .bg-color(white);
        padding: 21px 30px;

        &-screening {
            .width(886px, 47px);
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

        &-buttonAggregate {
            .flex(space-between, center);
            margin-top: 15px;

            &-left {

                &-btn {
                    margin-left: 20px;
                    padding: 0px 13px;
                    height: 25px;
                    background-color: #f0883a;
                    font-size: 14px;
                    color: #ffffff;
                    border: none;
                }
            }

            &-right {
                &-sort {
                    font-size: 14px;
                    color: #666666;
                    margin-right: 13px;
                }
            }
        }

        &-Tips {
            width: 885px;
            height: 38px;
            line-height: 38px;
            padding: 0px 14px;
            background-color: #fff8f3;
            border: solid 1px #f0883a;
            margin-top: 13px;
            font-size: 14px;
            color: #f0883a;
        }

        &-card {
            font-size: 0px;

            &-list {
                margin-right: (885px - (5 * 174px)) / 4;
                margin-bottom: (885px - (5 * 174px)) / 4;
                display: inline-block;
            }

            &-list:nth-child(5n) {
                margin-right: 0px;
            }
        }
    }
</style>