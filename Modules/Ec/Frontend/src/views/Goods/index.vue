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
        <router-view></router-view>

        <!-- 页脚 -->
        <v-footer-nav></v-footer-nav>
        <v-footer></v-footer>
        
        <!-- 侧边栏 -->
        <v-aside></v-aside>
    </div>
</template>

<script>
    import Header from "@/components/Header"
    import FooterNav from "@/components/Footer-nav"
    import Footer from "@/components/Footer"
    import Search from "@/components/Search"
    import Aside from "@/components/Aside"

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
            'v-aside': Aside,
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

</style>