<template>
    <div class="" id="carousel">
        <Carousel
            :height="440"
            v-model="value3"
            :loop="true"
            :autoplay="setting.autoplay"
            :autoplay-speed="setting.autoplaySpeed"
            :dots="setting.dots"
            :radius-dot="setting.radiusDot"
            :trigger="setting.trigger"
            :arrow="setting.arrow">
            <CarouselItem>
                <div class="demo-carousel">
                    <img :src="require('@/assets/img/home/banner.png')" alt="">
                </div>
            </CarouselItem>
            <CarouselItem>
                <div class="demo-carousel">
                    2
                </div>
            </CarouselItem>
            <CarouselItem>
                <div class="demo-carousel">
                    <img :src="require('@/assets/img/home/banner.png')" alt="">
                </div>
            </CarouselItem>
            <CarouselItem>
                <div class="demo-carousel">
                    4
                </div>
            </CarouselItem>
        </Carousel>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                value3: 0,
                setting: {
                    autoplay: false,
                    autoplaySpeed: 3000,
                    dots: 'inside',
                    radiusDot: false,
                    trigger: 'hover',
                    arrow: 'hover'
                }
            }
        },

    }
</script>

<style lang="less">
    #carousel {

        button.left.ivu-carousel-arrow {
            left: 251px + 16px;
        }

        ul.ivu-carousel-dots {
            width: 1220px - 251px;
            margin-left: 251px;
        }
    }
</style>
