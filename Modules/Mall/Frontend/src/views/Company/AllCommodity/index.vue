<template>
    <div>
        <!-- 首页 -->
        <v-header></v-header>

        <!-- banner -->
        <template>
            <section class="banner">
                <img :src="require('@/assets/img/home/banner3.png')" alt="">
            </section>
        </template>
        
        <!-- 导航 -->
        <v-nav></v-nav>

        <v-main></v-main>
    </div>
</template>

<script>
    import Header from "../components/Head/index"
    import Nav from '../components/Nav/index'
    import Main from './Main.vue'

    export default {
        data () {
            return {
                value3: 0,
                setting: {
                    autoplay: false,
                    autoplaySpeed: 2000,
                    dots: 'inside',
                    radiusDot: false,
                    trigger: 'click',
                    arrow: 'hover',
                    height: 500
                }
            }
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
