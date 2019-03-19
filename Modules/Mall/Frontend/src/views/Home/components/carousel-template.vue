<template>
    <div class="" id="carousel">
        <Carousel
            :height="440"
            :loop="true"
            :autoplay="setting.autoplay"
            :autoplay-speed="setting.autoplaySpeed"
            :dots="setting.dots"
            :radius-dot="setting.radiusDot"
            :trigger="setting.trigger"
            :arrow="setting.arrow">
            <!-- <CarouselItem v-for="(item, index) in slides" :key="index">
                <router-link tag="div" :to="item.jump_url" class="demo-carousel">
                    <img :src="item.image_url" alt="" style="width: 100%; height: 100%;">
                </router-link>
            </CarouselItem> -->
            <CarouselItem v-if="slides.length > 0">
                <router-link tag="div" :to="slides[0].jump_url" class="demo-carousel">
                    <img :src="slides[0].image_url" alt="" style="width: 100%; height: 100%;">
                </router-link>
            </CarouselItem>
            <CarouselItem v-if="slides.length > 1">
                <router-link tag="div" :to="slides[1].jump_url" class="demo-carousel">
                    <img :src="slides[1].image_url" alt="" style="width: 100%; height: 100%;">
                </router-link>
            </CarouselItem>
            <CarouselItem v-if="slides.length > 2">
                <router-link tag="div" :to="slides[2].jump_url" class="demo-carousel">
                    <img :src="slides[2].image_url" alt="" style="width: 100%; height: 100%;">
                </router-link>
            </CarouselItem>
            <CarouselItem v-if="slides.length > 3">
                <router-link tag="div" :to="slides[3].jump_url" class="demo-carousel">
                    <img :src="slides[3].image_url" alt="" style="width: 100%; height: 100%;">
                </router-link>
            </CarouselItem>
            <CarouselItem v-if="slides.length > 4">
                <router-link tag="div" :to="slides[4].jump_url" class="demo-carousel">
                    <img :src="slides[4].image_url" alt="" style="width: 100%; height: 100%;">
                </router-link>
            </CarouselItem>
        </Carousel>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                setting: {
                    autoplay: true,
                    autoplaySpeed: 3000,
                    dots: 'inside',
                    radiusDot: false,
                    trigger: 'hover',
                    arrow: 'hover'
                },
            }
        },
        props: {
            slides: Array
        }
    }
</script>

<style lang="less">
    #carousel {

        .demo-carousel {
            width: 1220px;
            height: 440px;
            display: block;
        }

        button.left.ivu-carousel-arrow {
            left: 251px + 16px;
        }

        ul.ivu-carousel-dots {
            width: 1220px - 251px;
            margin-left: 251px;
        }
    }
</style>
