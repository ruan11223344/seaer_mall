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
                <div class="block-box-title">Afriby.com</div>
                <time class="block-box-time">2018-11-13 10:10</time>
                <p class="block-box-h1">About Afriby</p>
                <p>Afriby is a large-scale integrated cross-border e-commerce platform in China, specializing in overseas export and Kenya local commodity trading services.</p>
                <img :src="require('@/assets/img/4.png')" alt="">
                <p class="block-box-h1">Afriby main service content and objects</p>
                <p>Afriby offers you products from China and Kenya, including furniture, home furnishings, auto parts, lamps, outdoor products, hardware, building materials, hotel supplies, etc. Merchants and buyers mainly from China and Kenya can help you efficiently find the products you need faster .</p>
                <img :src="require('@/assets/img/5.png')" alt="">
                <p class="block-box-h1">One-stop service</p>
                <p>The Afriby platform provides one-stop service including : China inbound cargo storage, overseas public service warehouses, product translation, order processing, international logistics, door-to-door delivery, platform payment, and after-sale services for enterprises that have joined the platform.</p>
                <img :src="require('@/assets/img/6.png')" alt="">
                <p class="block-box-h1">Find what you need, anytime, anywhere</p>
                <p>As a platform, we will continue to develop services to help your business growth and discover new opportunities. Whether you're purchasing locally or contacting a foreign business partner, turn to Afriby.com to meet your business needs.</p>
                <img :src="require('@/assets/img/7.png')" alt="">
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
                margin: 10px 0px;
            }

            & > &-h1 {
                font-size: 14px;
                font-weight: normal;
                font-stretch: normal;
                line-height: 37px;
                letter-spacing: 0px;
                color: #f0883a;
            }
        }
    }
</style>