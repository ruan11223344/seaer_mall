<template>
    <div>
        <!-- 广告 -->
        <template v-if="banner != null">
            <template v-for="(item, index) in banner">
                <v-banner :data_obj="item" :key="index" v-if="item.comment == '顶部'"></v-banner>
            </template>
        </template>
        <!-- 头部导航 -->
        <header class="header">
            <v-nav></v-nav>
        </header>

        <main class="main">
            <!-- 搜索 -->
            <section class="container main-search">
                <v-search></v-search>
            </section>
            <!-- 轮播图 -->
            <section class="container main-carousel" v-loading="AsideClass == null">
                <template v-if="AsideClass != null">
                    <v-cell :AsideClass="AsideClass"></v-cell>
                </template>
                <template v-if="slide != null">
                    <v-carousel :slides="slide"></v-carousel>
                </template>
            </section>
            <!-- 广告列 -->
            <section class="container main-banners" v-loading="banner == null">
                <template v-if="banner != null">
                    <!-- 跳转到分类页面 -->
                    <template v-for="(item, index) in banner">
                            <router-link class="main-banners-link" :key="index" :to="item.jump_url" v-if="item.comment == '广告1'">
                                <v-img width="393" height="200" :img-src="item.image_url"/>
                            </router-link>
                    </template>

                    <template v-for="(item, index) in banner">
                            <router-link class="main-banners-link" :key="index" :to="item.jump_url" v-if="item.comment == '广告2'">
                                <v-img width="393" height="200" :img-src="item.image_url"/>
                            </router-link>
                    </template>

                    <template v-for="(item, index) in banner">
                            <router-link class="main-banners-link" :key="index" :to="item.jump_url" v-if="item.comment == '广告3'">
                                <v-img width="393" height="200" :img-src="item.image_url"/>
                            </router-link>
                    </template>

                </template>
            </section>

            <div class="main-container">
                <!-- 广告 -->
                <section class="container main-banner" v-loading="banner == null">
                    <template v-if="banner != null">
                        <template v-for="(item, index) in banner">
                            <router-link
                                v-if="item.comment == '中部'"
                                :key="index"
                                tag="div"
                                :to="item.jump_url"
                                :style="`background: url(${item.image_url}) center center;height: 122px;cursor: pointer;`"
                                >
                            </router-link>
                        </template>
                    </template>
                </section>

                <div style="height:385px;" v-loading="HomeData == null">
                    <template v-if="HomeData != null">
                        <!-- 标题 -->
                        <section class="container main-title">
                            <v-title left-title="Hot Recommend" :right-title="true" :data_product_All="HomeData.hot_recommend"></v-title>
                        </section>
                        <!-- 商品列表 -->
                        <section class="container main-item">
                            <!-- 渲染商品列表mock -->
                            <template v-for="(item, index) in HomeData.hot_recommend">
                                <template v-if="index < 5">
                                    <div class="main-item-block" :key="index">
                                        <v-card :data="item"></v-card>
                                    </div>
                                </template>
                            </template>
                        </section>
                    </template>
                </div>

                <div style="height:385px;" v-loading="HomeData == null">
                    <template v-if="HomeData != null">
                        <!-- 标题 -->
                        <section class="container main-title">
                            <v-title
                                left-title="Personal Recommend"
                                :right-title="true"
                                :data_product_All="HomeData.personal_recommend">
                            </v-title>
                        </section>
                        <!-- 商品列表 -->
                        <section class="container main-item">
                            <!-- 渲染商品列表mock -->
                            <template v-for="(item, index) in HomeData.personal_recommend">
                                <template v-if="index < 5">
                                    <div class="main-item-block" :key="index">
                                        <v-card :data="item"></v-card>
                                    </div>
                                </template>
                            </template>
                        </section>
                    </template>
                </div>

                <!-- 广告 -->
                <section class="container main-banner" style="marginTop: 28px" v-loading="banner == null">
                    <template v-if="banner != null">
                        <template v-for="(item, index) in banner">
                            <router-link
                                v-if="item.comment == '底部'"
                                :key="index"
                                tag="div"
                                :to="item.jump_url"
                                :style="`background: url(${item.image_url}) center center;height: 122px;cursor: pointer;`"
                                >
                            </router-link>
                        </template>
                    </template>
                </section>

                <!-- 历史纪录 -->
                <template v-if="product_viewed != undefined">
                    <div v-if="product_viewed.length">
                        <!-- 标题 -->
                        <section class="container main-title">
                            <v-title left-title="My Recently Viewed Items"></v-title>
                        </section>
                        <!-- 商品列表 -->
                        <section class="container main-item main-itemRecord">
                            <div class="main-record-arrow main-record-arrow-left" @click="onClickRecordLeft">
                                <Icon type="ios-arrow-dropleft-circle" size="30"/>
                            </div>
                            <div class="main-record" ref="record">
                                <!-- 渲染历史记录mock -->
                                <template v-for="(item, index) in product_viewed">
                                    <!-- <template v-if="index < 5"> -->
                                        <v-card class="main-record-list" :data="item" :key="index"></v-card>
                                    <!-- </template> -->
                                </template>
                            </div>
                            <div class="main-record-arrow main-record-arrow-right" @click="onClickRecordRight">
                                <Icon type="ios-arrow-dropright-circle" size="30"/>
                            </div>
                        </section>
                    </div>
                </template>
            </div>
        </main>
        <!-- 右侧栏 -->
        <section>
            <v-aside></v-aside>
        </section>
        
        <v-footer-nav></v-footer-nav>
        <v-footer></v-footer>
    </div>
</template>

<script>
    import Banner from "@/components/Banner"
    import Header from "@/components/Header"
    import FooterNav from "@/components/Footer-nav"
    import Footer from "@/components/Footer"
    import Img from "@/components/Img"
    import Card from "@/components/Card"
    import Search from "@/components/Search"
    import Aside from "@/components/Aside"
    import getData from "@/utils/getData"

    import titleTemplateVue from './components/title-template.vue'
    import carouselTemplateVue from './components/carousel-template'
    import cellTemplateVue from './components/cell-template.vue'
    import auth from '../../utils/auth.js'

    export default {
        data() {
            return {
                RecordIndex: 0,
                HomeData: null,
                AsideClass: null,
                slide: null,
                banner: null,
                product_viewed: null
            }
        },
        methods: {
            onGetProductRecommend: getData.onGetProductRecommend,
            onGetAsideClass: getData.onGetAsideClass,
            onGetAdInfo: getData.onGetAdInfo,
            onClickRecordLeft() {// 历史记录左滑动
                this.RecordIndex <= 0 ? this.RecordIndex = 0 : this.RecordIndex--
                const record = this.$refs.record
                record.style.left = -((228 + 20) * this.RecordIndex) + 'px'
            },
            onClickRecordRight() {// 历史记录右滑动
                const record = this.$refs.record
                const children = record.children   
                this.RecordIndex >= children.length - 5 ? this.RecordIndex : this.RecordIndex++
                record.style.left = -((228 + 20) * this.RecordIndex) + 'px'
            },
            GetWidth() {
                // 动态计算历史记录宽度
                const record = this.$refs.record
                const children = record.children
                record.style.width = (228 + 20) * children.length - 20 + 'px'
            }
        },
        mounted() {
            const user_id = auth.getSessionStorage()
            this.onGetProductRecommend(user_id != null ? user_id.user.id : '').then(res => {
                this.HomeData = res
                this.product_viewed = res.product_viewed
            })

            this.onGetAsideClass().then(res => {
                this.AsideClass = res
            })

            this.onGetAdInfo().then(({ slide, banner }) => {
                this.slide = slide
                this.banner = banner
            })
        },
        components: {
            'v-banner': Banner,
            'v-img': Img,
            'v-nav': Header,
            'v-card': Card,
            'v-title': titleTemplateVue,
            'v-search': Search,
            'v-carousel': carouselTemplateVue,
            'v-cell': cellTemplateVue,
            'v-aside': Aside,
            'v-footer-nav': FooterNav,
            'v-footer': Footer
        },
        watch: {
            HomeData(newVal) {
                if(this.newVal != null) {
                    this.GetWidth()
                }
            }
        },
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .header {
        .layout(40px);
        .bg-color(dark);
    }
    .main {
        // 搜索
        &-search {
            height: 100px;
        }
        // 轮播
        &-carousel {
            height: 440px;
            background-color: whitesmoke;
            position: relative;
        }
        // 广告列
        &-banners {
            // .flex(space-between);
            .bg-color(white);
            height: 200px;
            margin-top: 20px;
            margin-bottom: 20px;
            display: block;

            &-link {
                display: inline-block;
                margin-right: (1220px - 393px * 3) / 2;
            }

            &-link:nth-child(4n) {
                display: inline-block;
                margin-right: 0px;
            }
        }

        &-container {
            min-width: 1220px;
            padding-top: 19px;
            padding-bottom: 30px;
            .bg-color(light);
        }

        &-banner {
            height: 122px;
        }

        &-title {
            height: 35px;
            .lineHeight(35px);
            margin-top: 15px;
            margin-bottom: 10px;
        }

        &-item {
            width: 1220px;
            height: 340px;
            // .flex(space-between, center);
            overflow: hidden;
            position: relative;

            &-block {
                display: inline-block;
                margin-right: (1220px - 228px * 5) / 4;
            }

            &-block:nth-child(5n) {
                margin-right: 0px;
            }
        }

        &-itemRecord:hover {
            .main-record-arrow {
                display: block;
            }
        }

        &-record-arrow {
            width: 40px;
            height: 40px;
            position: absolute;
            top: 319px / 2 - 20px;
            .flex(center,center);
            cursor: pointer;
            display: none;
            opacity: 0.6;
            transition: opacity 0.5s;
            z-index: 1000;
        }

        &-record-arrow:hover {
            opacity: 1;
        }

        &-record-arrow-left {
            left: 0px;
        }

        &-record-arrow-right {
            right: 0px;
        }

        &-record {
            height: 319px;
            position: relative;
            left: 0px;
            transition: all 0.2s;
            &-list:first-child {
                margin-left: 0px;
            }
            &-list {
                display: inline-block;
                width: 228px;
                margin-left: 20px;
            }
    
        }
    }

</style>