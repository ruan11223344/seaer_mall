<template>
    <div>
        <main class="main">
            <section class="container main-title">
                <!-- <v-Breadcrumb
                    title="Home"
                    :Breadcrumbs="[ 'List of commodities' ]"
                    :url="`/home`"
                    >
                </v-Breadcrumb> -->
            </section>
            <section class="container main-content" v-if="Product_All.length">
                <!-- 渲染商品列表mock -->
                <v-card class="main-content-list" :data="item" v-for="(item, index) in ProductData" :key="index"></v-card>
            </section>
            <section v-else class="main-tips">
                <img :src="require('@/assets/img/spk.png')" alt="">
                <span>
                    There is no merchandise in this category for the time being.
                </span>
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
    import auth from '@/utils/auth'
    // import Breadcrumb  from '@/components/Breadcrumb'

    export default {
        data() {
            return {
                total: {
                    size: 10,
                    total: 0,
                    num: 1
                },
                ProductData: [],
                Product_All: []
            }
        },
        computed: {
        },
        methods: {
            filterAll: getData.filterAll,
            // 分页
            onPages(index) {
                this.$set(this.total, 'num', index)
                this.filterAll(this.Product_All, this.total)
                    .then(res => this.ProductData = res)
            },
            ongGetAll() {
                this.Product_All = auth.getProductAllStorage()

                this.total.total = this.Product_All.length
                this.filterAll(this.Product_All, this.total)
                    .then(res => this.ProductData = res)
            }
        },
        mounted() {
            this.ongGetAll()
        },
        components: {
            'v-card': Card,
        },
        watch: {
            '$route': function () {
                this.ongGetAll()
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
                display: inline-block;
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

    }
</style>