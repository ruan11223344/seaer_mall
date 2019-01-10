<template>
    <div>
        <!-- 首页 -->
        <v-header></v-header>
        
        <!-- 导航 -->
        <v-nav></v-nav>

        <Carousel
            v-model="value3"
            :autoplay="setting.autoplay"
            :autoplay-speed="setting.autoplaySpeed"
            :dots="setting.dots"
            :radius-dot="setting.radiusDot"
            :trigger="setting.trigger"
            :arrow="setting.arrow"
            :height="setting.height">
            <CarouselItem>
                <div class="demo-carousel">1</div>
            </CarouselItem>
            <CarouselItem>
                <div class="demo-carousel">2</div>
            </CarouselItem>
            <CarouselItem>
                <div class="demo-carousel">3</div>
            </CarouselItem>
            <CarouselItem>
                <div class="demo-carousel">4</div>
            </CarouselItem>
        </Carousel>

        <v-main></v-main>
    </div>
</template>

<script>
    import Header from "../components/Head/index"
    import Nav from '../components/Nav/index'
    import Main from './Main.vue'

    export default {
        data () {
            return {
                value3: 0,
                setting: {
                    autoplay: false,
                    autoplaySpeed: 2000,
                    dots: 'inside',
                    radiusDot: false,
                    trigger: 'click',
                    arrow: 'hover',
                    height: 500
                }
            }
        },
        components: {
           "v-header": Header,
           "v-nav": Nav,
           "v-main": Main
        }
    }
</script>

<style lang="less" scoped>
    
</style>
