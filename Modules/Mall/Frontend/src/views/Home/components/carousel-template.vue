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
            <CarouselItem v-for="(item, index) in slides" :key="index">
                <router-link tag="div" :to="item.jump_url" class="demo-carousel">
                    <img :src="item.image_url" alt="" style="width: 100%; height: 100%;">
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
                    autoplay: false,
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
