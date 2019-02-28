<template>
    <div>
        <v-head-template></v-head-template>
        
        <section class="details-banner">
            <img src="" alt="">
        </section>

        <v-goods-nav></v-goods-nav>
        
        <main class="main">
            <!-- 商品 -->
            <section class="container main-goods">
                <div class="main-goods-left">
                    <div class="main-goods-left-picture">
                        <!-- 放大镜 -->
                        <v-zoom :imgSrc="imgSrc"></v-zoom>
                    </div>
                    <ul class="main-goods-left-pictureItem">
                        <li class="main-goods-left-pictureList" v-for="(item, index) in ImgItem" :key="index" @click="imgSrc = item">
                            <v-img width="58" height="58" :imgSrc="item.imgSrcThumbnail"/>
                        </li>
                    </ul>
                    <div class="main-goods-left-pictureBottom">
                        <div class="main-goods-left-pictureBottom-icon" @click="onCollection">
                            <img :src="isCollection ? require('@/assets/img/details/sc2.png') : require('@/assets/img/details/sc1.png')" alt="">
                        </div>
                        <span>Add to Favorites</span>
                    </div>
                    <!-- 模态框 -->
                </div>

                <v-content></v-content>

                <v-right></v-right>
            </section>

            <section class="container" style="marginTop:50px">
                <v-footer-template></v-footer-template>
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

    export default {
        data() {
            return {
                imgSrc: {
                    imgSrc: require('@/assets/img/details/tp.png'),
                    imgSrcAmplification: require('@/assets/img/details/tp.png')
                },
                ImgItem: [
                    {
                        imgSrcThumbnail: require('@/assets/img/details/tp.png'),
                        imgSrc: require('@/assets/img/details/tp.png'),
                        imgSrcAmplification: require('@/assets/img/details/tp.png')
                    },
                    {
                        imgSrcThumbnail: require('@/assets/img/details/tp.png'),
                        imgSrc: require('@/assets/img/details/tp.png'),
                        imgSrcAmplification: require('@/assets/img/details/tp.png')
                    }
                ],
                // 收藏
                isCollection: false,
                ProductData: []
            }
        },
        methods: {
            onGetProductInfo: getData.onGetProductInfo,
            onSetFavorites: upData.onSetFavorites,
            onCollection() { // 收藏商品
                this.onSetFavorites({ product_or_company_id: this.ProductData.product_attr.id, type: "product" })
            }
        },
        mounted() {
            this.onGetProductInfo(this.$route.query.product_id).then(res => {this.ProductData = res;console.log(res)})
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
    
    .details-banner {
        width: 100%;
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
