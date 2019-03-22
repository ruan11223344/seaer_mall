<template>
    <div>
        <Carousel
            v-if="Company_Detail.shop_info.slides.length > 1"
            :loop="true"
            :autoplay="setting.autoplay"
            :autoplay-speed="setting.autoplaySpeed"
            :dots="setting.dots"
            :radius-dot="setting.radiusDot"
            :trigger="setting.trigger"
            :arrow="setting.arrow"
            :height="setting.height">
            <template v-for="(item, index) in Company_Detail.shop_info.slides">
                <CarouselItem :key="index">
                    <a
                        :href="item.url_jump"
                        target="_blank"
                        style="`display: block;`"
                        >
                        <div :style="`display: block;width: 100%; height: 500px;background: url(${item.url}) center center`"></div>
                        <!-- <img style="width: 100%; height: 100%; display: block;" :src="item.url" alt="">  -->
                    </a>
                </CarouselItem>
            </template>
        </Carousel>

        <template v-else-if="Company_Detail.shop_info.slides.length == 1">
            <a
                :href="Company_Detail.shop_info.slides[0].url_jump"
                target="_blank"
                >
                <div :style="`display: block;width: 100%; height: 500px;background: url(${Company_Detail.shop_info.slides[0].url}) center center`"></div>
            </a>
        </template>

        <v-main></v-main>
    </div>
</template>

<script>
    import Main from './Main.vue'
    import getData from '@/utils/getData'
    import { mapState, mapMutations } from "vuex"

    export default {
        data () {
            return {
                setting: {
                    autoplay: true,
                    autoplaySpeed: 5000,
                    dots: 'inside',
                    radiusDot: false,
                    trigger: 'click',
                    arrow: 'hover',
                    height: 500
                }
            }
        },
        computed: {
            ...mapState([ 'Company_Detail' ])
        },
        methods: {
            ...mapMutations([ 'SET_COMPANY_DETAIL' ]),
            onGetCompanyDetail: getData.onGetCompanyDetail,
        },
        created() {
            if(!this.Company_Detail) {
                this.onGetCompanyDetail(this.$route.query.company_id)
                .then(res => {
                    this.SET_COMPANY_DETAIL(res)
                })
            }
        },
        mounted() {
            
        },
        components: {
           "v-main": Main
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');
</style>
