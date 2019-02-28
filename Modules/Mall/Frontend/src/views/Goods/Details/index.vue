<template>
    <div v-if="ProductData">
        <v-head-template :name="formData.basic_info.company_name" :bool="ProductData.is_favorites_shop" @on-click="onGetData"></v-head-template>
        
        <section class="details-banner">
            <img :src="formData.shop_info.banner.banner_url" alt="">
        </section>

        <v-goods-nav></v-goods-nav>
        
        <main class="main">
            <!-- 商品 -->
            <section class="container main-goods">
                <div class="main-goods-left">
                    <div class="main-goods-left-picture">
                        <!-- 放大镜 -->
                        <v-zoom :imgSrc="ProductData.product_info.product_images_url[activeIndex]"></v-zoom>
                    </div>
                    <ul class="main-goods-left-pictureItem">
                        <li
                            class="main-goods-left-pictureList"
                            :style="activeIndex==index ? 'border: 1px solid #d72b2b' : 'border: 1px solid #dddddd'"
                            v-for="(item, index) in ProductData.product_info.product_images_url"
                            :key="index"
                            @click="activeIndex = index">
                            <v-img width="58" height="58" :imgSrc="item"/>
                        </li>
                    </ul>
                    <div class="main-goods-left-pictureBottom">
                        <div class="main-goods-left-pictureBottom-icon" @click="onCollection(ProductData.product_info.id)">
                            <img :src="ProductData.is_favorites_product ? require('@/assets/img/details/sc2.png') : require('@/assets/img/details/sc1.png')" alt="">
                        </div>
                        <span>Add to Favorites</span>
                    </div>
                    <!-- 模态框 -->
                </div>
                <v-content @on-click="onClickImg" :active="activeIndex" :dataFrom="ProductData"></v-content>

                <v-right :formData="formData"></v-right>
            </section>

            <section class="container" style="marginTop:50px">
                <v-footer-template :product_details="ProductData.product_info.product_details"></v-footer-template>
            </section>
        </main>
      
    </div>
</template>

<script>
    // 放大镜
    import Zoom from './components/Zoom.vue'
    import Img from '@/components/Img/index.vue'
    import Right from './components/Right-template'
    import Content from './components/Content-template'
    import footerTemplateVue from './components/footer-template.vue';
    import headTemplateVue from './components/head-template.vue';
    import getData from "@/utils/getData"
    import upData from "@/utils/upData"
    import Nav from '../../Goods/components/Nav'
    import { mapState } from "vuex"

    export default {
        data() {
            return {
                activeIndex: 0,
                // 收藏
                isCollection: false,
                ProductData: null,
                formData: {}
            }
        }, 
        computed: {
            ...mapState([ 'User_Info' ])
        },
        methods: {
            onGetProductInfo: getData.onGetProductInfo,
            onSetFavorites: upData.onSetFavorites,
            onGetCompanyDetail: getData.onGetCompanyDetail,
            onDelFavorites: upData.onDelFavorites,
            onCollection(id) { // 收藏商品
                if(this.User_Info == '') {
                    this.$router.push('/login')
                }else {
                    if(this.ProductData.is_favorites_product) {
                        // 删除
                        this.onDelFavorites({ 
                            product_or_company_id_list: [ id ],
                            type: "product"
                        })
                            .then(res => {
                                this.onGetProductInfo(this.$route.query.product_id, this.User_Info.user.id)
                                    .then(res => this.ProductData = res)
                            }
                        )
                    }else {
                        // 添加
                        this.onSetFavorites({
                            product_or_company_id: id,
                            type: "product"
                        })
                            .then(res => {
                                this.onGetProductInfo(this.$route.query.product_id, this.User_Info.user.id)
                                    .then(res => this.ProductData = res)
                            }
                        )
                    }
                }
            },
            // 放大镜
            onClickImg(index) {
                this.activeIndex = index
            },
            onGetData() {
                this.onGetCompanyDetail(this.$route.query.company_id)
                    .then(res => {this.formData = res; console.log(res)})

                if(this.User_Info == '') {
                    this.onGetProductInfo(this.$route.query.product_id)
                        .then(res => this.ProductData = res)
                }else {
                    this.onGetProductInfo(this.$route.query.product_id, this.User_Info.user.id)
                        .then(res => this.ProductData = res)
                }
            }
        },
        mounted() {
            this.onGetData()
        },
        components: {
            'v-zoom': Zoom,
            'v-img': Img,
            'v-right': Right,
            'v-content': Content,
            'v-footer-template': footerTemplateVue,
            'v-head-template': headTemplateVue,
            'v-goods-nav': Nav
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');
    // @import '~snow.css';

    .details-banner {
        width: 100%;
        min-width: 1220px;
        height: 150px;
	    background-color: #f6eded;
    }

    // 头部
    .main-title {
        .lineHeight(45px);
    }
    .main {
        margin: 25px 0px;

        &-goods {
            .flex(space-between, flex-start, row);
            .bg-color(white);
            height: auto;

            &-left {
                .bg-color(white);
                width: 350px;
                position: relative;

                &-picture {
                    .width(350px, 350px);
                    .bg-color(white);
                    border: solid 1px #dddddd;
                    position: relative;
                }

                &-pictureItem {
                    height: 60px;
                    .flex(flex-start);
                    margin: 10px 0px 18px 0px;
                }

                &-pictureList {
                    .width(60px, 60px);
                    margin-right: (350px - 60 * 5) / 4;
                    border: 1px solid #dddddd;
                    // box-shadow: 0 0 5px 1px #dddddd;
                    cursor: pointer;
                }
                &-pictureList:nth-child(5n) {
                    margin-right: 0;
                }

                &-pictureBottom {
                    .flex(flex-start, center);
                    .color(blackLight);
                    height: 11px;
                    font-size: 14px;
                    line-height: 1;
                    margin-left: 6px;

                    &-icon {
                        .width(16px, 16px);
                        margin-right: 6px;
                        position: relative;
                        top: -2px;
                        cursor: pointer;

                        & > img {
                            .width(16px, 16px);
                        }
                    }
                }

            }
            
        }
    }
</style>
