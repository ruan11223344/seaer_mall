<template>
    <div class="resetPass">
        <header class="container resetPass-header">
            <router-link to="/home" tag="div" class="resetPass-head">
                <img :src="require('@/assets/img/home/logo.png')" alt="">
            </router-link>
            <div class="resetPass-link">
                <div class="resetPass-link-login">Sign In</div>
                <div class="resetPass-link-region" @click="onClick">{{ Countries ? 'Chinese Supplier please check here'  : 'Kenya Supplier please check here'}}</div>
            </div>
        </header>
        <main class="main">
            <router-view></router-view>
        </main>
        <footer>Copyright © 2018-2019  Afriby.com  All Rights Reserved.</footer>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {
        name: 'app',
        data() {
            return {
            }
        },
        computed: {
            ...mapState([ 'Countries' ])
        },
        methods: {
            ...mapMutations([ 'SET_COUNTRIES' ]),
            onClick() {
                this.SET_COUNTRIES()
                console.log(this.Countries)
            }
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

        &-header {
            .flex(space-between, center);

            .resetPass-link {
                height: 100%;
                .flex();

                &-login {
                    font-size: 16px;
                    line-height: 1;
                    letter-spacing: 0px;
                    color: #666666;
                    margin-right: 39px;
                    cursor: pointer;
                    position: relative;
                }

                &-login::before {
                    content: '';
                    width: 1px;
                    height: 13px;
                    background-color: #cccccc;
                    position: absolute;
                    right: -39px / 2;
                    top: 1px;
                    cursor: initial;
                }

                &-region {
                    font-size: 16px;
                    line-height: 1;
                    letter-spacing: 0px;
                    color: #666666;
                    cursor: pointer;
                }
            }
        }

        &-head {
            .flex(flex-start, center);
            height: 88px;

            & > img {
                .width(181px, 53px);
            }
        }

        & > .main {
            .flex(center, center);
            width: 100%;
            height: auto;
            background-color: #f0f1f5;
            padding-top: 46px;
            padding-bottom: 40px;
        }

        & > footer {
            .bg-color(white);
            .flex(center, center);
            .color(blackLight);
            height: 100px;
        }
    }
        
</style>
