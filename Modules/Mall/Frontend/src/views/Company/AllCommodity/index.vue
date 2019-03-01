<template>
    <div class="allCommodity">

        <div class="container">
            <v-Breadcrumb
                title="Supplier Homepage"
                :Breadcrumbs="[ 'Products' ]"
                :url="`/company/home?&company_id=${$route.query.company_id}`"
                >
            </v-Breadcrumb>
        </div>

        <div class="container allCommodity-main">
            <!-- 侧边栏 -->
            <div class="allCommodity-main-aside">
                <v-aside></v-aside>
            </div>

            <div class="company-home-main-content">
                <div class="company-home-main-content-first">
                    <div class="company-home-main-content-title">{{ $route.query.group_name }} <span>Total {{ total.total }} {{ $route.query.group_name }} Products</span></div>
                    <div class="company-home-main-content-first-item" v-if="commodityFilters.length">
                        <!-- 渲染商品列表mock -->
                        <v-card :data="item" v-for="(item, index) in commodityFilters" :key="index" class="company-home-main-content-first-item-list"></v-card>
                    </div>

                    <div v-else style="textAlign: center;lineHeight: 100px;">
                        No merchandise for the time being
                    </div>
                </div>

                <!-- 分页 -->
                <section style="marginTop:20px;">
                    <template>
                        <Page :total="total.total" :page-size="total.size" style="textAlign: center" @on-change="onPages"/>
                    </template>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
    import Aside from '../components/Aside/index.vue'
    import Card from "@/components/Card"
    import Breadcrumbs  from '@/components/Breadcrumb'
    import getData  from '@/utils/getData'

    export default {
        data() {
            return {
                total: {
                    size: 16,
                    total: 0,
                    num: 1
                },
                // 商品列表
                commodityAll: [],
                commodityFilters: []
            }
        },
        methods: {
            onGetProductList: getData.onGetProductList,
            filterAll: getData.filterAll,
            // 获取商品列表
            onGetList() {
                this.onGetProductList(this.$route.query.group_id)
                .then(res => {
                    this.commodityAll = res
                    this.total.total = this.commodityAll.length
                    this.filterAll(this.commodityAll, this.total).then(res => this.commodityFilters = res)
                })
            },
            // 分页
            onPages(index) {
                this.$set(this.total, 'num', index)
                this.filterAll(this.commodityAll, this.total).then(res => this.commodityFilters = res)
            }
        },
        mounted() {
            this.onGetList()
        },
        watch: {
            '$route' (to, form ) {
                this.onGetList()
            }
        },
        components: {
            "v-aside": Aside,
            'v-card': Card,
            "v-Breadcrumb": Breadcrumbs 
        }
    }
</script>

<style lang="less" scoped>
    @import url("../../../assets/css/index");

    .company-home-main-content {
        // margin-left: 20px;
        width: 972px;

        &-title {
            font-size: 16px;
            line-height: 1;
            color: #666666; 
            margin-top: 5px;  
            margin-bottom: 16px; 

            & > span {
                font-size: 14px;
                color: #999999;
            }
        }

        &-first {
            &-item {
                .flex();
                flex-wrap: wrap;

                &-list {
                    margin-right: 20px;
                    margin-bottom: 20px;
                }

                &-list:nth-child(4n) {
                    margin-right: 0px;
                }
            }
        }
    }

    .allCommodity {
        padding: 24px 0px;
        background-color: #f5f5f5;
        
        &-main {
            width: 1220px;
            margin-top: 14px;
            .flex(space-between);
        }
    }
</style>
