<template>
    <div>
        <main class="main">
            <section class="container main-title">
                <v-Breadcrumb
                    title="Home"
                    :Breadcrumbs="[ 'List of commodities' ]"
                    :url="`/home`"
                    >
                </v-Breadcrumb>
            </section>
            <!-- 店铺详情 -->
            <section class="container main-content">
                <div class="container main-content-list">
                    <img class="container main-content-list-img" :src="require('@/assets/img/cm.png')" alt="">
                    <div class="container main-content-list-text">
                        <div class="container main-content-list-text-top">
                            Wuhan Sier International Co.,LTD.
                            <img :src="true ? require('@/assets/img/ina.png') : require('@/assets/img/ya.png')" alt="">
                        </div>
                        <div class="container main-content-list-text-content">
                            Telephone：+86 027-65520870
                        </div>
                        <div class="container main-content-list-text-bottom">
                            Address：Room 605,Building A,No.777,Optical Valley three Road
                        </div>
                    </div>
                    <button class="container main-content-list-btn" type="button">View shop</button>
                </div>
            </section>
            <!-- 分页 -->
            <section class="container main-page">
                <template>
                    <Page :total="total.total" :page-size="total.size" style="textAlign: center" @on-change="onPages"/>
                </template>
            </section>
        </main>
    </div>
</template>

<script>
    import getData from '@/utils/getData'
    import { mapState } from 'vuex'
    import Breadcrumb  from '@/components/Breadcrumb'

    export default {
        data() {
            return {
                total: {
                    size: 10,
                    total: 0,
                    num: 1
                },
                ProductData: []
            }
        },
        computed: {
            ...mapState([ 'Product_All' ])
        },
        methods: {
            filterAll: getData.filterAll,
            // 分页
            onPages(index) {
                this.$set(this.total, 'num', index)
                this.filterAll(this.Product_All, this.total)
                    .then(res => this.ProductData = res)
            }
        },
        mounted() {
            this.total.total = this.Product_All.length
            this.filterAll(this.Product_All, this.total)
                .then(res => this.ProductData = res)
        },
        components: {
            "v-Breadcrumb": Breadcrumb 
        },
        watch: {
            Product_All() {
                this.total.total = this.Product_All.length
                this.filterAll(this.Product_All, this.total)
                    .then(res => this.ProductData = res)
            }
        },
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .main {
        .bg-color(light);
            
        // 头部
        &-title {
            height: 45px;
            line-height: 45px;
        }

        // 商品列表
        &-content {
            .flex(space-between, center, column);

            &-list {
                .flex(space-between, center, row);
                width: 1220px;
                height: 161px;
                background-color: #ffffff;
                margin-bottom: 20px;

                &-img {
                    width: 88px;
                    height: 88px;
                    display: block;
                    margin-left: 30px;
                    margin-right: 25px;
                }

                &-text {
                    .flex(space-around, flex-start, column);
                    width: 900px;
                    height: 88px;

                    &-top {
                        .flex(flex-start, center);
                        width: 900px;
                        height: 15px;
                        font-size: 16px;
                        line-height: 1;
                        color: #333333;

                        & > img {
                            margin-left: 8px;
                        }
                    }
                    
                    &-content, &-bottom {
                        width: 900px;
                        height: 11px;
                        font-size: 12px;
                        line-height: 1;
                        color: #666666;
                    }

                    &-content {
                        margin-top: 20px;
                    }

                    &-bottom {
                        margin-top: 11px;
                    }
                }

                &-btn {
                    width: 109px;
                    height: 33px;
                    background-color: #ef873a;
                    font-size: 14px;
                    line-height: 1;
                    color: #ffffff;
                    border: none;
                }
            }
            
        }

        &-page {
            height: 48px + 26px + 34px;
            padding-top: 26px;
        }

    }
</style>