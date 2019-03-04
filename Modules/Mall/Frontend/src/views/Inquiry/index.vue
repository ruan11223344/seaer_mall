<template>
    <div id="goods-list">
        <!-- 头部导航 -->
        <header class="header">
            <v-nav></v-nav>
        </header>
        
        <div style="backgroundColor:#ffffff">
            <!-- 搜索 -->
            <section class="container search">
                <v-search></v-search>
            </section>
        </div>

        <!-- 子页面渲染 -->
        <main class="inquiry">
            <div class="container inquiry-main">
                <!-- <section class="inquiry-main-title">
                    <Breadcrumb separator='<b style="color:#666666">></b>'>
                        <BreadcrumbItem to="/" class="inquiry-main-title-active">Home</BreadcrumbItem>
                        <BreadcrumbItem style="color:#666666">{{" $route.query.name" }}</BreadcrumbItem>
                    </Breadcrumb>
                </section> -->
                <section class="inquiry-main-main">
                    <!-- 侧边栏 -->
                    <v-inquiry-aside></v-inquiry-aside>

                    <!-- <v-inquiry-main></v-inquiry-main> -->
                    <router-view></router-view>
                </section>
            </div>
        </main>
        
        <v-aside></v-aside>

        <!-- 页脚 -->
        <v-footer-nav></v-footer-nav>
        <v-footer></v-footer>
    </div>
</template>

<script>
    import Header from "@/components/Header"
    import FooterNav from "@/components/Footer-nav"
    import Footer from "@/components/Footer"
    import Search from "@/components/Search"
    import Aside from "@/components/Aside"
    import inquiryAside from "./components/Aside/index"

    export default {
        data() {
            return {

            }
        },
        components: {
            'v-nav': Header,
            'v-search': Search,
            'v-footer-nav': FooterNav,
            'v-footer': Footer,
            "v-aside": Aside,
            "v-inquiry-aside": inquiryAside
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
    .search {
        height: 100px;
    }
    .inquiry {
        .flex(center, center);
        width: 100%;
        min-width: 1220px;
        height: auto;
        background-color: #f0f1f5;
        padding-top: 20px;
        padding-bottom: 20px;

        &-main {

            &-title {
                margin-bottom: 8px;

                // &-avtive {
                //     & > a:hover {
                //         color: #f0883a !important;
                //     }
                // }
            }

            &-main {
                .flex(space-between, flex-start);
            }
        }
    }

</style>