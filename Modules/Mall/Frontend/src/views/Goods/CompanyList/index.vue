<template>
    <div>
        <main class="main">
            <!-- 店铺详情 -->
            <section class="container main-content">
                <template v-if="CompanyData.length">
                    <template v-for="(item, index) in CompanyData">
                        <div class="container main-content-list" :key="index">
                            <img class="container main-content-list-img" :src="require('@/assets/img/cm.png')" alt="">
                            <div class="container main-content-list-text">
                                <div class="container main-content-list-text-top">
                                    {{ item.company_name }}
                                    <img :src="item.company_country_name == 'Kenya' ? require('@/assets/img/ya.png') : require('@/assets/img/ina.png')" alt="">
                                </div>
                                <div class="container main-content-list-text-content">
                                    Telephone：{{ item.telephone }}
                                </div>
                                <div class="container main-content-list-text-bottom">
                                    Address：{{ item.company_detailed_address }}
                                </div>
                            </div>
                            <button class="container main-content-list-btn" type="button" @click="onClick(item.id)">View shop</button>
                        </div>
                    </template>
                </template>

                <template v-else>
                    <section class="main-tips">
                        <img :src="require('@/assets/img/dpk.png')" alt="">
                        <span>
                            There are no shops in this category for the time being.
                        </span>
                    </section>
                </template>
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
    import { mapState, mapMutations } from 'vuex'
    import auth from "@/utils/auth"

    export default {
        data() {
            return {
                total: {
                    size: 6,
                    total: 0,
                    num: 1
                },
                CompanyData: [],
                Shop_All: []
            }
        },
        methods: {
            ...mapMutations([ 'SET_COMPANY_DETAIL' ]),
            filterAll: getData.filterAll,
            // 分页
            onPages(index) {
                this.$set(this.total, 'num', index)
                this.filterAll(this.Shop_All, this.total)
                    .then(res => this.CompanyData = res)
            },
            onClick(id) {
                this.Shop_All = auth.getShopAllStorage()

                this.SET_COMPANY_DETAIL('')
                this.$router.push('/company/home?company_id=' + id)
            },
            ongGetAll() {
                this.Shop_All = auth.getShopAllStorage()
                this.total.total = this.Shop_All.length
                this.filterAll(this.Shop_All, this.total)
                    .then(res => this.CompanyData = res)
            }
        },
        created() {
            this.ongGetAll()
        },
        watch: {
            
            '$route': function () {
                this.ongGetAll()
            }
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .main {
        .bg-color(light);
        padding-top: 20px;
            
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

        &-tips {
            .flex(center, center, column);
            height: 500px;
            text-align: center;
            font-size: 16px;
            color: #666666;

            & > span {
                margin-top: 20px;
            }
        }

        &-page {
            height: 48px + 26px + 34px;
            padding-top: 26px;
        }

    }
</style>