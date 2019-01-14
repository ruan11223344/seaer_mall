<template>
    <div>
        <!-- 广告 -->
        <v-banner :imgSrc="require('@/assets/img/home/toub.png')"></v-banner>
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
            <section class="container main-carousel">
                <v-cell></v-cell>
                <v-carousel></v-carousel>
            </section>
            <!-- 广告列 -->
            <section class="container main-banners">
                <!-- 跳转到分类页面 -->
                <router-link :to="'/goods/list?name=' + item.title" v-for="(item, index) in banners" :key="index">
                    <v-img width="393" height="200" :img-src="item.imgSrc"/>
                </router-link>
            </section>

            <div class="main-container">
                <!-- 广告 -->
                <section class="container main-banner">
                    <v-img width="1220" height="122" :img-src="require('@/assets/img/home/banner3.png')" />
                </section>

                <div>
                    <!-- 标题 -->
                    <section class="container main-title">
                        <v-title left-title="Hot Recommend" :right-title="true"></v-title>
                    </section>
                    <!-- 商品列表 -->
                    <section class="container main-item">
                        <!-- 渲染商品列表mock -->
                        <v-card :title="title" :price="price" :img-src="imgSrc" v-for="({title, price, imgSrc}, index) in goodsLists" :key="index"></v-card>
                    </section>
                </div>

                <div>
                    <!-- 标题 -->
                    <section class="container main-title">
                        <v-title left-title="New Arrivals" :right-title="true"></v-title>
                    </section>
                    <!-- 商品列表 -->
                    <section class="container main-item">
                        <!-- 渲染商品列表mock -->
                        <v-card :title="title" :price="price" :img-src="imgSrc" v-for="({title, price, imgSrc}, index) in goodsLists" :key="index"></v-card>
                    </section>
                </div>

                <!-- 广告 -->
                <section class="container main-banner" style="marginTop: 28px">
                    <v-img width="1220" height="122" :img-src="require('@/assets/img/home/banner3.png')"></v-img>
                </section>

                <!-- 历史纪录 -->
                <div>
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
                            <v-card class="main-record-list" :title="title" :price="price" :img-src="imgSrc" v-for="({title, price, imgSrc}, index) in record" :key="index"></v-card>
                        </div>
                        <div class="main-record-arrow main-record-arrow-right" @click="onClickRecordRight">
                            <Icon type="ios-arrow-dropright-circle" size="30"/>
                        </div>
                    </section>
                </div>
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

    import titleTemplateVue from './components/title-template.vue'
    import carouselTemplateVue from './components/carousel-template'
    import cellTemplateVue from './components/cell-template.vue'

    export default {
        data() {
            return {
                RecordIndex: 0,
                // 广告列
                banners: [
                    {
                        title: 'home appliances',
                        imgSrc: require('@/assets/img/home/banner1.png'),
                    },
                    {
                        title: 'camera',
                        imgSrc: require('@/assets/img/home/banner1.png'),
                    },
                    {
                        title: 'jacket',
                        imgSrc: require('@/assets/img/home/banner1.png'),
                    }
                ],
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
                // 历史记录mock
                record: [
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "2.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "3.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "4.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "5.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "6.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "7.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "8.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "9.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "10.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                ]
            }
        },
        methods: {
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
            }
        },
        mounted() {
            this.$request({
                url: '/tags'
            }).then(res => {
                console.log(res)
            }).catch(err => {
                console.log(err)
            })

            // 动态计算历史记录宽度
            const record = this.$refs.record
            const children = record.children   
            record.style.width = (228 + 20) * children.length - 20 + 'px'
        },
        created() {

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
        }
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
            .flex(space-between);
            .bg-color(light);
            height: 200px;
            margin-top: 20px;
            margin-bottom: 20px;
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
            height: 319px;
            .flex(space-between, center);
            overflow: hidden;
            position: relative;
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
            .flex(space-between, center);
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