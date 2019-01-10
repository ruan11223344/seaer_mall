<template>
    <div>
        <div style="backgroundColor: #f5f5f9">
            <section class="container main-title">
                <Breadcrumb separator='<b style="color:#666666">></b>'>
                    <BreadcrumbItem to="/">Home</BreadcrumbItem>
                    <BreadcrumbItem style="color:#666666">{{ '$route.query.name' }}</BreadcrumbItem>
                </Breadcrumb>
            </section>
        </div>

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
                        <!-- <Icon :type="isCollection ? 'ios-star' : 'ios-star-outline'" color="#f39e5f" size="18" class="main-goods-left-pictureBottom-icon" @click="onCollection"/>
                        -->
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
                        imgSrcThumbnail: require('@/assets/img/details/demo1.jpg'),
                        imgSrc: require('@/assets/img/details/demo1.jpg'),
                        imgSrcAmplification: require('@/assets/img/details/demo1.jpg')
                    },
                    {
                        imgSrcThumbnail: require('@/assets/img/details/demo.jpg'),
                        imgSrc: require('@/assets/img/details/demo.jpg'),
                        imgSrcAmplification: require('@/assets/img/details/demo.jpg')
                    },
                    {
                        imgSrcThumbnail: require('@/assets/img/details/demo.jpg'),
                        imgSrc: require('@/assets/img/details/demo.jpg'),
                        imgSrcAmplification: require('@/assets/img/details/demo.jpg')
                    },
                    {
                        imgSrcThumbnail: require('@/assets/img/details/demo.jpg'),
                        imgSrc: require('@/assets/img/details/demo.jpg'),
                        imgSrcAmplification: require('@/assets/img/details/demo.jpg')
                    }
                ],
                // 收藏
                isCollection: false
            }
        },
        methods: {
            onCollection() { // 收藏功能
                this.isCollection = !this.isCollection
                if(this.isCollection) {
                    this.$Message.success('您已经收藏成功了 | You have to collect a success');
                }else {
                    this.$Message.warning('您已经取消收藏了 | You have already cancelled the collection')
                }
            }
        },
        components: {
            'v-zoom': Zoom,
            'v-img': Img,
            'v-right': Right,
            'v-content': Content,
            'v-footer-template': footerTemplateVue
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');
    
    .pic-box {
        .width(200px, 500px);
        position: relative;
        z-index: 10000;
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
                    .flex(space-between);
                    margin: 10px 0px 18px 0px;
                }

                &-pictureList {
                    .width(60px, 60px);
                    border: solid 1px #dddddd;
                    cursor: pointer;
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
