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
            <CarouselItem v-if="slides.length > 0">
                <div class="demo-carousel">
                    <a :href="slides[0].jump_url" target="_blank" rel="noopener noreferrer">
                        <img :src="slides[0].image_url" alt="" style="width: 100%; height: 100%;">
                    </a>
                </div>
            </CarouselItem>
            <CarouselItem v-if="slides.length > 1">
                <div class="demo-carousel">
                    <a :href="slides[1].jump_url" target="_blank" rel="noopener noreferrer">
                        <img :src="slides[1].image_url" alt="" style="width: 100%; height: 100%;">
                    </a>
                </div>
            </CarouselItem>
            <CarouselItem v-if="slides.length > 2">
                <div class="demo-carousel">
                    <a :href="slides[2].jump_url" target="_blank" rel="noopener noreferrer">
                        <img :src="slides[2].image_url" alt="" style="width: 100%; height: 100%;">
                    </a>
                </div>
            </CarouselItem>
            <CarouselItem v-if="slides.length > 3">
                <div class="demo-carousel">
                    <a :href="slides[3].jump_url" target="_blank" rel="noopener noreferrer">
                        <img :src="slides[3].image_url" alt="" style="width: 100%; height: 100%;">
                    </a>
                </div>
            </CarouselItem>
            <CarouselItem v-if="slides.length > 4">
                <div class="demo-carousel">
                    <a :href="slides[4].jump_url" target="_blank" rel="noopener noreferrer">
                        <img :src="slides[4].image_url" alt="" style="width: 100%; height: 100%;">
                    </a>
                </div>
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
