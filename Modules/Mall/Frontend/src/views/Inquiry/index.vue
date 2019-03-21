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
                <section class="inquiry-main-main">
                    <!-- 侧边栏 -->
                    <div>
                        <v-inquiry-aside></v-inquiry-aside>
                    </div>
                    <div>
                        <router-view></router-view>
                    </div>
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
        width: 100%;
        min-width: 1220px;
        height: auto;
        background-color: #f0f1f5;
        padding-top: 20px;
        padding-bottom: 20px;

        &-main {
            &-title {
                margin-bottom: 8px;
            }

            &-main {
                & > div {
                    vertical-align: top;
                    display: inline-block;
                }

                & > div:first-child {
                    margin-right: 1220px - 237px - 18px - 885px - 60px;
                }
            }
        }
    }

</style>