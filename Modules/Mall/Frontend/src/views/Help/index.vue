<template>
    <div>
        <!-- 头部导航 -->
        <header class="header">
            <v-nav></v-nav>
        </header>

        <main class="main">
            <!-- 搜索 -->
            <section class="container main-search">
                <v-search></v-search>
            </section>
        </main>
        
        <section class="block">
            <div class="block-box">
                <div class="block-box-title">Finding & Contacting</div>
                <time class="block-box-time">2018-11-13 10:10</time>
                <p>How to search and Contact sellers?</p>
                <p>How do buyers search for products and enter stores to contact sellers?</p>
                <p>1.Log in to the home page and enter the name of the product you are looking for.</p>
                <img :src="require('@/assets/img/1.png')" alt="">
                <p>2.Enter the seller's store and contact the seller.</p>
                <img :src="require('@/assets/img/2.png')" alt="">
                <p>3.Send an email to purchase a product.</p>
                <img :src="require('@/assets/img/3.png')" alt="">
            </div>
        </section>
        <v-footer-nav></v-footer-nav>
        <v-footer></v-footer>
    </div>
</template>

<script>
    import Header from "@/components/Header"
    import FooterNav from "@/components/Footer-nav"
    import Footer from "@/components/Footer"
    import Search from "@/components/Search"

    export default {
        data() {
            return {
            }
        },
        components: {
            'v-nav': Header,
            'v-search': Search,
            'v-footer-nav': FooterNav,
            'v-footer': Footer
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .header {
        background-color: #000;
    }
    .main {
        background-color: #ffffff;
    }
    .block {
        width: 100%;
        margin: 0px auto;
        padding: 20px 0px;
        background-color: #f5f5f9;

        &-box {
            width: 1220px;
            height: auto;
            background-color: #ffffff;
            margin: 0px auto;
            padding: 50px 25px;
            line-height: 2;

            &-title {
                font-size: 20px;
                color: #666666;
                text-align: center;
            }

            &-time {
                text-align: center;
                display: block;
            }
            
            & > p {
                font-size: 14px;
                color: #666666;
            }

            & > img {
                width: 100%;
                height: auto;
                display: block;
            }
        }
    }
</style>