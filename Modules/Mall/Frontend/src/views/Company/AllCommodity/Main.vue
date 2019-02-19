<template>
    <div class="allCommodity">

        <div class="container">
            <v-Breadcrumb title="Supplier Homepage" :Breadcrumbs="[ 'Products' ]"></v-Breadcrumb>
        </div>

        <div class="container allCommodity-main">
            <!-- 侧边栏 -->
            <div class="allCommodity-main-aside">
                <v-aside></v-aside>
            </div>

            <div class="company-home-main-content">
                <div class="company-home-main-content-first">
                    <div class="company-home-main-content-title">All Products <span>Total {{ '189' }} Products</span></div>
                    <div class="company-home-main-content-first-item">
                        <!-- 渲染商品列表mock -->
                        <v-card :title="title" :price="price" :img-src="imgSrc" v-for="({title, price, imgSrc}, index) in goodsLists" :key="index" class="company-home-main-content-first-item-list"></v-card>
                    </div>
                </div>

                <!-- 分页 -->
                <section style="marginTop:20px;">
                    <template>
                        <Page :total="100" :page-size="8" style="textAlign: center"/>
                    </template>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
    import Aside from '../components/Aside/index.vue'
    import Card from "@/components/Card"
    import Breadcrumb  from '@/components/Breadcrumb'


    export default {
        data() {
            return {
                // 商品列表
                goodsLists: [
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                ],
            }
        },
        components: {
            "v-aside": Aside,
            'v-card': Card,
            "v-Breadcrumb": Breadcrumb 
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
