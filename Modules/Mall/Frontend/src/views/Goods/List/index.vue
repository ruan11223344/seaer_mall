<template>
    <div>
        <main class="main">
            <!-- <section class="container main-title">
                <v-Breadcrumb
                    title="Home"
                    :Breadcrumbs="[ 'List of commodities' ]"
                    :url="`/home`"
                    >
                </v-Breadcrumb>
            </section> -->
            <section class="container main-content">
                <!-- 渲染商品列表mock -->
                <v-card class="main-content-list" :data="item" v-for="(item, index) in ProductData" :key="index"></v-card>
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
    import Card from "@/components/Card"
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
            'v-card': Card,
            // "v-Breadcrumb": Breadcrumb 
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
            .flex(flex-start, center, row);
            flex-wrap: wrap;

            // 商品
            &-list:first-child {
                margin-left: 0px;
            }
            &-list:nth-child(6n) {
                margin-left: 0px;
            }
            &-list {
                margin-left: 20px;
                margin-bottom: 20px;
                cursor: pointer;
            }
        }

        &-page {
            height: 48px + 26px + 34px;
            padding-top: 26px;
            .flex(center);

            &-pg {
                .lineHeight(32px);
                .color(gray);
                position: relative;
                left: 3px;
            }

            &-bt {
                .lineHeight(32px);
                .bg-color(orange2);
                .color(white);
                width: 45px;
                margin-left: 19px;
                text-align: center;
                cursor: pointer;
            }
        }

    }
</style>