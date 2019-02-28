<template >
    <div v-if="Company_Detail">
        <!-- 首页 -->
        <v-header></v-header>

        <!-- banner -->
        <template>
            <section class="banner">
                <img :src="Company_Detail.shop_info.banner.banner_url" alt="">
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
    import Header from "../components/Head/index"
    import Nav from '../components/Nav/index'
    import Main from './Main.vue'
    import getData from '@/utils/getData'
    import { mapState, mapMutations } from "vuex"


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
            }
        },
        computed: {
            ...mapState([ 'User_Info', 'Company_Detail' ])
        },
        methods: {
            ...mapMutations([ 'SET_COMPANY_DETAIL' ]),
            onGetCompanyDetail: getData.onGetCompanyDetail,
            onGetBanner: getData.onGetBanner
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
