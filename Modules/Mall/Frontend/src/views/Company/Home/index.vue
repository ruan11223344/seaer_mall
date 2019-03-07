<template >
    <div v-if="Company_Detail">
        <Carousel
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
                    <img style="width: 100%; height: 100%; display: block;" :src="item.url" alt="">
                </CarouselItem>
            </template>
        </Carousel>
        
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
                },
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
