<template>
    <main class="company-home-main-content">
        <div class="company-home-main-content-first">
            <div class="company-home-main-content-title">Hot Recommend</div>
            <div class="company-home-main-content-first-item">
                <!-- 渲染商品列表mock -->
                <v-card :data="item" v-for="(item, index) in Company_Detail.shop_info.product_recommend" :key="index" class="company-home-main-content-first-item-list"></v-card>
            </div>
        </div>
        <div class="company-home-main-content-first">
            <div class="company-home-main-content-title">New Arrivals</div>
            <div class="company-home-main-content-first-item">
                <!-- 渲染商品列表mock -->
                <v-card :data="item" v-for="(item, index) in Company_Detail.shop_info.product_last_update" :key="index" class="company-home-main-content-first-item-list"></v-card>
            </div>
        </div>
    </main>
</template>

<script>
    import Card from "@/components/Card"
    import { mapState, mapMutations } from "vuex"

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
        computed: {
            ...mapState([ 'User_Info', 'Company_Detail' ])
        },
        components: {
            'v-card': Card,
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
</style>
