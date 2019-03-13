<template>
    <div class="login">
        <header>
            <router-link to="/home" tag="div" class="login-head">
                <img :src="require('@/assets/img/home/logo.png')" alt="">
            </router-link>
        </header>
        <main class="login-main">
            <div class="box">
                <div></div>
                <button type="button" @click="$router.push('/home')">Back to home</button>
            </div>
        </main>
        <footer>Copyright © 2018-2019  Afriby.com  All Rights Reserved.</footer>
    </div>
</template>

<script>

    export default {
        name: 'app',
        data() {
            return {
                
            }
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .login {
        .bg-color(white);

        &-head {
            .flex(flex-start, center);
            height: 88px;
            margin-left: 18.2%;
            cursor: pointer;

            & > img {
                .width(181px, 53px);
            }
        }

        &-main {
            width: 100%;
            height: e("calc(100vh - 188px)");
            padding-top: 20px;
            box-sizing: border-box;
            background-color: #f5f5f9;

            .box {
                .width(1200px, 684px);
                margin: 0px auto;
                .bg-color(white);
                position: relative;

                & > div {
                    .width(100%, 684px);
                    background: url('../../assets/img/404.png') center center;
                    background-repeat: no-repeat;
                }

                & > button {
                    width: 124px;
                    height: 36px;
                    background-color: #f0883a;
                    font-size: 16px;
                    line-height: 1;
                    color: #ffffff;
                    border: none;
                    position: absolute;
                    top: 76%;
                    left: (1200px / 2) - (124px / 2);
                }
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
