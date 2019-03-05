<template>
    <div>
        <!-- 首页 -->
        <!-- 头部导航 -->
        <header class="header">
            <v-nav></v-nav>
        </header>

        <template v-if="Company_Detail">
            <v-company @on-click="getCompany"></v-company>
        </template>

        <!-- banner -->
        <template v-if="Company_Detail">
            <template v-if="Company_Detail.shop_info.banner.banner_url">
                <section class="banner">
                    <img :src="Company_Detail.shop_info.banner.banner_url" alt="">
                </section>
            </template>
        </template>
        
        <!-- 导航 -->
        <v-nav-list></v-nav-list>

        <template  v-if="Company_Detail">
            <!-- 子页面渲染 -->
            <router-view></router-view>
        </template>

        <!-- 页脚 -->
        <v-footer-nav></v-footer-nav>
        <v-footer></v-footer>
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

    export default {
        computed: {
            ...mapState([ 'User_Info', 'Company_Detail' ])
        },
        methods: {
            ...mapMutations([ 'SET_COMPANY_DETAIL' ]),
            onGetCompanyDetail: getData.onGetCompanyDetail,
            getCompany() {
                const user_id = this.User_Info ? this.User_Info.user.id : null
                this.onGetCompanyDetail(this.$route.query.company_id, user_id)
                    .then(res => {
                        this.SET_COMPANY_DETAIL(res)
                    })
            }
        },
        created() {
            if(!this.Company_Detail) {
                this.getCompany()
            }
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
