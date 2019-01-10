<template>
    <div class="resetPass">
        <header>
            <router-link to="/home" tag="div" class="resetPass-head">
                <img :src="require('@/assets/img/home/logo.png')" alt="">
            </router-link>
        </header>
        <router-view></router-view>
        <footer>Copyright © 2018-2019  Afriby.com  All Rights Reserved.</footer>
    </div>
</template>

<script>
    export default {
        name: 'app',
        data() {
            return {
               
            }
        },
        methods: {
            
        },
        mounted() {
        },
        components: {
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .resetPass {
        .bg-color(white);
        &-head {
            .flex(flex-start, center);
            height: 88px;
            margin-left: 18.2%;

            & > img {
                .width(181px, 53px);
            }
        }

        & > footer {
            .bg-color(white);
            .flex(center, center);
            .color(blackLight);
            height: 100px;
        }
    }
        
</style>
