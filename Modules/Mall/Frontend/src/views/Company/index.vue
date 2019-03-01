<template>
    <div>
        <!-- 首页 -->
        <!-- 头部导航 -->
        <header class="header">
            <v-nav></v-nav>
        </header>

        <!-- 搜索 -->
        <!-- <div style="backgroundColor:#ffffff">
            <section class="container search">
                <v-search></v-search>
            </section>
        </div> -->

        <!-- 子页面渲染 -->
        <router-view></router-view>

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
    
    export default {
        computed: {
            ...mapState([ 'User_Info', 'Company_Detail' ])
        },
        methods: {
            ...mapMutations([ 'SET_COMPANY_DETAIL' ]),
            onGetCompanyDetail: getData.onGetCompanyDetail
        },
        created() {
            if(!this.Company_Detail) {
                this.onGetCompanyDetail(this.$route.query.company_id)
                .then(res => {
                    this.SET_COMPANY_DETAIL(res)
                })
            }
        },
        components: {
            'v-nav': Header,
            // 'v-search': Search,
            'v-footer-nav': FooterNav,
            'v-footer': Footer,
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

    
</style>
