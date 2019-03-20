<template>
    <div style="min-height: 500px;" v-loading="Company_Detail == null">
        <template v-if="Company_Detail">
            <!-- 首页 -->
            <!-- 头部导航 -->
            <header class="header">
                <v-nav></v-nav>
            </header>

            <v-company @on-click="getCompany"></v-company>

            <!-- banner -->
            <template v-if="Object.prototype.toString.call(Company_Detail.shop_info.banner) == '[object Object]'">
                <section class="banner">
                    <img :src="Company_Detail.shop_info.banner.banner_url" alt="">
                </section>
            </template>
            
            <!-- 导航 -->
            <v-nav-list></v-nav-list>

            <!-- 子页面渲染 -->
            <router-view></router-view>

            <!-- 页脚 -->
            <v-footer-nav></v-footer-nav>
            <v-footer></v-footer>
        </template>
    </div>
</template>

<script>
    import { mapState, mapMutations } from "vuex"
    import Header from "@/components/Header"
    import FooterNav from "@/components/Footer-nav"
    import Footer from "@/components/Footer"
    import getData from '@/utils/getData'
    // import Search from "@/components/Search"
    import Nav from "./components/Nav/index"
    import Company from "../Goods/Details/components/head-template.vue"
    import Cookies from "@/utils/auth"

    export default {
        data() {
            return {
                user: null
            }
        },
        computed: {
            ...mapState([ 'Company_Detail' ])
        },
        methods: {
            ...mapMutations([ 'SET_COMPANY_DETAIL' ]),
            onGetCompanyDetail: getData.onGetCompanyDetail,
            getSessionStorage: Cookies.getSessionStorage,
            getCompany() {
                const user_id = this.user ? this.user.user.id : null
                this.onGetCompanyDetail(this.$route.query.company_id, user_id)
                    .then(res => {
                        this.SET_COMPANY_DETAIL(res)
                    })
            }
        },
        created() {
            this.user = this.getSessionStorage()
            this.getCompany()
        },
        components: {
            'v-nav': Header,
            'v-footer-nav': FooterNav,
            'v-footer': Footer,
            "v-nav-list": Nav,
            "v-company": Company
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');
    
    .header {
        .layout(40px);
        background-color: #1c1a1a;
    }
    // 搜索
    // .search {
    //     height: 100px;
    // }

    .banner {
        height: 150px;

        & > img {
            .width(100%, 100%);
        }
    }
</style>
