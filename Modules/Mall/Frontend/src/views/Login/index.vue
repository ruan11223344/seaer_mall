<template>
    <div class="login">
        <header>
            <router-link to="/home" tag="div" class="login-head">
                <img :src="require('@/assets/img/home/logo.png')" alt="">
            </router-link>
        </header>
        <main class="login-main">
            <div class="box">
                <div class="box-title">Account</div>
                <!-- 用户id -->
                <section class="box-useId">
                    <input type="text" placeholder="Please enter your Email Address or Member ID." v-model="rulesFrom.userId" v-verify="rulesFrom.userId">
                    <div class="box-useId-prompt" v-remind="rulesFrom.userId"></div>
                </section>
                <section class="box-title">
                    <span>Password:</span>
                    <router-link to="/" tag="div" class="box-title-link">Forgot your password?</router-link>
                </section>
                <!-- 用户密码 -->
                <section class="box-useId">
                    <input type="password" placeholder="Please enter your password." v-model="rulesFrom.password" v-verify="rulesFrom.password">
                    <div class="box-useId-prompt" v-remind="rulesFrom.password">Incorrect Password.</div>
                </section>
                <!-- 验证码 -->
                <section class="box-useId box-code" style="marginTop: 40px;">
                    <input type="text" placeholder="Please enter verification code.">
                    <div class="box-useId-prompt">Incorrect captcha.please enter the text in the image.</div>
                    <div class="box-code-rex">
                        <div>
                            <!-- 验证码图片 -->
                           <img src="" alt="">
                        </div>
                        <Icon type="md-refresh" size="30"/>
                    </div>
                </section>
                <div class="box-btn" @click="onSubmit" id="Login-btn">Sign In</div>
                <router-link to="/" tag="div" class="box-registered">New User ？Join In</router-link>
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
                rulesFrom: {
                    userId: '',
                    password: ''
                }
            }
        },
        verify: {
            // 验证
            rulesFrom: {
                userId: [
                    'LoginUserId'
                ],
                password: [
                    'LoginPassword'
                ]
            }
        },
        methods: {
            onSubmit() {
                if(this.$verify.check()) {
                    this.$Message.info('3秒后跳转到首页')

                    setTimeout(() => {
                        this.$router.push('/')
                    }, 3000)
                }
            },
        },
        mounted() {
        },
        components: {
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

            & > img {
                .width(181px, 53px);
            }
        }

        &-main {
            width: 100%;
            height: e("calc(100vh - 188px)");
            background: url('../../assets/img/login/bg.png') center center;
            background-size: cover;

            .box {
                .width(770px, 589px);
                padding-top: 60px;
                padding-left: 52px;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -51.6%);
                position: relative;

                &-title {
                    .lineHeight(37px);
                    .flex(space-between, center);
                    .color(blackDark);
                    width: 660px;
                    letter-spacing: 0px;

                    &-link {
                        .color(blackLight);
                        cursor: pointer;
                        position: relative;
                    }

                    &-link::before {
                        content: '';
                        .width(100%, 1px);
                        .bg-color(blackLight);
                        position: absolute;
                        bottom: 10px;
                    }

                    &-link:hover {
                        .color(Orange);
                    }

                    &-link:hover::before {
                        .bg-color(Orange)
                    }
                }

                &-useId {
                    margin-bottom: 31px;
                    position: relative;

                    & > input {
                        .width(660px, 61px);
                        border: solid 2px #eeeeee;
                        padding-left: 21px;
                        .color(blackLight);
                    }

                    &-prompt {
                        .lineHeight(13px);
                        font-size: 13px;
                        position: absolute;
                        left: 0px;
                        bottom: -20px;
                        .color(red);
                    }
                }
                
                &-code {
                    width: 660px;
                    cursor: pointer;
                    &-rex {
                        .width(172px, 60px);
                        .flex(space-between, center);
                        .bg-color(whiteLight);
                        padding: 0px 15px;
                        position: absolute;
                        top: 0px;
                        right: 0px;
                    }
                }

                &-btn {
                    .lineHeight(61px);
                    .bg-color(Orange);
                    .color(white);
                    width: 657px;
                    margin-top: 68px;
                    font-size: 22px;
                    text-align: center;
                    cursor: pointer;
                }

                &-registered {
                    .color(blackLight);
                    .width(657px, 12px);
                    line-height: 37px;
                    text-align: center;
                    cursor: pointer;
                }

                &-registered:hover {
                    .color(Orange);
                }
            }
            .box, .box::after, .box::before {
                content: '';
                .bg-color(white);
                position: absolute;
            }
            .box::after {
                .width(745px, 12px);
                opacity: 0.48;
                left: (770px - 745px) / 2;
                bottom: -12px;
            }
            .box::before {
                .width(726px, 9px);
                opacity: 0.39;
                left: (770px - 726px) / 2;
                bottom: -21px;
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
