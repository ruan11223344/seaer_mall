<template>
    <div>
        <!-- 首页 -->
        <v-header></v-header>

        <!-- banner -->
        <template>
            <section class="banner">
                <img :src="require('@/assets/img/home/banner3.png')" alt="">
            </section>
        </template>
        
        <!-- 导航 -->
        <v-nav></v-nav>

        <Carousel
            :loop="true"
            :autoplay="setting.autoplay"
            :autoplay-speed="setting.autoplaySpeed"
            :dots="setting.dots"
            :radius-dot="setting.radiusDot"
            :trigger="setting.trigger"
            :arrow="setting.arrow"
            :height="setting.height">
            <template v-for="(item, index) in slidesList">
                <CarouselItem :key="index">
                    <img style="width: 100%; height: 100%; display: block;" :src="item.url" alt="">
                </CarouselItem>
            </template>
        </Carousel>

        <v-main></v-main>
    </div>
</template>

<script>
    import Header from "../components/Head/index"
    import Nav from '../components/Nav/index'
    import Main from './Main.vue'
    import getData from '@/utils/getData'


    export default {
        data () {
            return {
                setting: {
                    autoplay: true,
                    autoplaySpeed: 2000,
                    dots: 'inside',
                    radiusDot: false,
                    trigger: 'click',
                    arrow: 'hover',
                    height: 500
                },
                slidesList: []
            }
        },
        methods: {
            onGetSlidesList: getData.onGetSlidesList,
            onGetBanner: getData.onGetBanner
        },
        mounted() {
            this.onGetSlidesList().then(res => {
                this.slidesList = res
            })

            // this.onGetBanner().then(res => {

            // })
        },
        components: {
           "v-header": Header,
           "v-nav": Nav,
           "v-main": Main
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .banner {
        height: 150px;

        & > img {
            .width(100%, 100%);
        }
    }
</style>
