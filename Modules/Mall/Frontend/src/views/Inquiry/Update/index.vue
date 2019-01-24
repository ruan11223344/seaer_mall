<template>
    <div class="product">
        <v-head></v-head>
        <v-title title="Upload Product" subtitle="(1 added, maximum 200）"></v-title>

        <section class="Send-main-screening">
            <div class="Send-main-screening-text Send-main-screening-text-active">Search</div>
            <div class="Send-main-screening-hr"></div>
            <div class="Send-main-screening-text">Latest Selected</div>
        </section>

        <section class="product-search">
            <input type="text" class="product-search-input">
            <button type="button" class="product-search-btn">Search</button>
        </section>

        <!-- 地址 -->
        <!-- <section class="product-category">
            <div class="product-category-item">
                <happy-scroll
                    size="6"
                    :hide-horizontal="true"
                    :min-length-v="10"
                    color="#dddddd"
                    >
                   <Card shadow style="width: 260px;border:none;boxShadow: none;">
                        <CellGroup>
                            <Cell title="Construction" class="product-category-item-list product-category-item-active"/>
                            <Cell title="Only show titles" class="product-category-item-list" v-for="(item, index) in [0,1,2,3,4,5,3,6,7,8,1,1,1,1,1,1,1,1,11,1,1]" :key="index"/>
                        </CellGroup>
                    </Card>
                </happy-scroll>
            </div>
            <div class="product-category-item" style="borderLeft: none;">
                <happy-scroll
                    size="6"
                    :hide-horizontal="true"
                    :min-length-v="10"
                    color="#dddddd"
                    >
                        <Card shadow style="width: 260px;border:none;boxShadow: none;">
                            <CellGroup>
                                <Cell title="Home improvement building materials" class="product-category-item-list product-category-item-active"/>
                                <Cell title="Only show titles" class="product-category-item-list" v-for="(item, index) in [0,1,2]" :key="index"/>
                            </CellGroup>
                        </Card>
                </happy-scroll>
            </div>
            <div class="product-category-item" style="borderLeft: none;">
                <happy-scroll
                    size="6"
                    :hide-horizontal="true"
                    :min-length-v="10"
                    color="#dddddd"
                    >
                    <Card shadow style="width: 260px;border:none;boxShadow: none;">
                        <CellGroup>
                            <Cell title="Floor" class="product-category-item-list product-category-item-active"/>
                            <Cell title="Only show titles" class="product-category-item-list" v-for="(item, index) in [0,1,2,3,4,5,3,6,7,8,1,1,1,1,1,1,1,1,11,1,1]" :key="index"/>
                        </CellGroup>
                    </Card>
                </happy-scroll>
            </div>
        </section> -->

        <!-- 模糊搜索 -->
        <section class="product-blurry">
            <span class="product-blurry-title">All Categories</span>

            <div class="product-blurry-item">
                <happy-scroll
                    size="6"
                    :hide-horizontal="true"
                    :min-length-v="10"
                    color="#dddddd"
                    >
                    <Card shadow style="width: 863px;border:none;boxShadow: none;">
                        <CellGroup>
                            <Cell title="Construction" class="product-blurry-item-list product-blurry-item-active"/>
                            <Cell title="Only show titles" class="product-blurry-item-list" v-for="(item, index) in [0,1,2,3,4,5,3,6,7,8,1,1,1,1,1,1,1,1,11,1,1]" :key="index"/>
                        </CellGroup>
                    </Card>
                </happy-scroll>
            </div>
        </section>

        <!-- 选择的地址 -->
        <section class="product-footer">

        </section>

        <button type="button" class="product-btn">Select</button>
    </div>
</template>

<script>
    import Title from "../components/Title"
    import Img from "@/components/Img"
    import Head from "../components/Head"
    // 滚动条
    import { HappyScroll } from 'vue-happy-scroll'

    export default {
        data() {
            return {
                switchValue: true
            }
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-head": Head,
            "happy-scroll": HappyScroll
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');
    .product {
        width: 945px;
        height: 931px;
        background-color: #ffffff;
        padding: 21px 30px;

        &-search {
            margin: 20px 0px;

            &-input {
                width: 527px - 114px;
                height: 54px;
                border: solid 1px #dddddd;
                border-right: none;
            }

            &-btn {
                border: none;
                width: 114px;
                height: 54px;
                font-size: 16px;
                color: #666666;
            }
        }

        &-category {
            width: 885px;
            .flex();
            
            &-item {
                width: 885px / 3;
                height: 462px;
                border: solid 1px #dddddd;
                padding: 0px 10px;

                &-list {
                    height: 36px;
                    font-size: 14px;
                }

                &-list:hover {
                    background-color: #f5f5f9 !important;
                }

                &-active {
                    background-color: #f5f5f9;
                    color: #f0883a;
                }
            }
        }

        &-blurry {
            width: 885px;

            &-title {
                font-size: 16px;
                color: #f0883a;
                margin-left: 22px;
                margin-bottom: 8px;
                cursor: pointer;
                display: inline-block;
            }

            &-item {
                width: 885px;
                height: 462px;
                border: solid 1px #dddddd;
                padding: 0px 10px;

                &-list {
                    height: 36px;
                    font-size: 14px;
                }

                &-list:hover {
                    background-color: #f5f5f9 !important;
                }

                &-active {
                    background-color: #f5f5f9;
                    color: #f0883a;
                }
            }
        }

        &-footer {
            width: 885px;
            height: 40px;
            border: solid 1px #dddddd;
            border-top: none;
        }

        &-btn {
            border: none;
            width: 118px;
            height: 44px;
            background-color: #f0883a;
            font-size: 18px;
            color: #ffffff;
            display: block;
            margin: 0px auto;
            margin-top: 40px;
        }
    }

    .Send-main-screening {
        width: 885px;
        height: 47px;
        background-color: #f5f5f9;
        margin-top: 19px;
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
</style>
