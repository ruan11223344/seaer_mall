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
                    <input type="text" placeholder="Please enter your Email Address or Member ID." v-model="rulesFrom.userId" v-verify="rulesFrom.userId" @focus="bool=false" @keyup.enter="onSubmit">
                    <div class="box-useId-prompt" v-remind="rulesFrom.userId">Please enter your Email Address or Member ID.</div>
                    <div class="box-useId-prompt" v-show="bool">Please enter your Email Address or Member ID.</div>
                </section>
                <section class="box-title">
                    <span>Password:</span>
                    <router-link to="/reset/find" tag="div" class="box-title-link">Forgot your password?</router-link>
                </section>
                <!-- 用户密码 -->
                <section class="box-useId">
                    <input type="password" placeholder="Please enter your password." v-model="rulesFrom.password" v-verify="rulesFrom.password" @focus="bool=false" @keyup.enter="onSubmit">
                    <div class="box-useId-prompt" v-remind="rulesFrom.password">Please fill in the correct password</div>
                    <div class="box-useId-prompt" v-show="bool">Please fill in the correct password</div>
                </section>
                <!-- 验证码 -->
                <section class="box-useId box-code" style="marginTop: 40px;" v-show="num >= 2">
                    <input type="text" v-model="rulesFrom.code" placeholder="Please enter verification code." @focus="boolCode = false">
                    <div class="box-useId-prompt" v-show="bool || boolCode">Incorrect captcha.please enter the text in the image.</div>
                    <div class="box-code-rex" @click="getCodes">
                        <div>
                            <!-- 验证码图片 -->
                            <img :src="imgCode" alt="">
                        </div>
                        <Icon type="md-refresh" size="30"/>
                    </div>
                </section>
                <div class="box-btn" @click="onSubmit" id="Login-btn">Sign In</div>
                <router-link to="/registered/one" tag="div" class="box-registered">New User ？Join In</router-link>
            </div>
        </main>
        <footer>Copyright © 2018-2019  Afriby.com  All Rights Reserved.</footer>
    </div>
</template>

<script>
    // 引入公共获取数据方法
    import getData from '@/utils/getData'
    import Cookies from '@/utils/auth'

    export default {
        name: 'app',
        data() {
            return {
                rulesFrom: {
                    userId: '',
                    password: '',
                    code: '',
                    key: ''
                },
                imgCode: '',
                num: 0,
                bool: false,
                boolCode: false,
                login: true
            }
        },
        verify: {
            // 验证
            rulesFrom: {
                userId: [
                    'LoginUserId'
                ],
                // password: [
                //     'LoginPassword'
                // ]
            }
        },
        methods: {
            onGetUser: getData.onGetUser,
            getCode: getData.getCode,
            setCookies: Cookies.setCookies,
            refreshCookies: Cookies.refreshCookies,
            setSessionStorage: Cookies.setSessionStorage,
            getCodes() {
                const getCode = this.getCode()
                getCode.then(({ code, data }) => {
                    if(code == 200) {
                        this.imgCode = data.img
                        this.$set(this.rulesFrom, 'key', data.key)
                    }
                }).catch(err => err)
            },
            onSubmit() { // 提交
                if(this.num > 2) {
                    if(this.$verify.check() && this.rulesFrom.code !== '') {
                        this.upFrom()
                    }else {
                        this.boolCode = true
                    }
                }else {
                     if(this.$verify.check()) {
                        this.upFrom()
                    }
                }
            },
            upFrom() {
                this.$Spin.show()

                this.$request({
                url: '/auth/get_access_token',
                method: 'post',
                data: {
                        grant_type: 'password',
                        client_id: 2,
                        client_secret: 'LfmILOffY40xTlFbJT2Q0V8gWyyu99cwlElNPKrK',
                        username: this.rulesFrom.userId,
                        password: this.rulesFrom.password,
                        captcha: this.rulesFrom.code,
                        key: this.rulesFrom.key
                    }
                }).then(({code, data}) => {
                    if(code == 200) {
                        this.setCookies(data.access_token)
                        this.refreshCookies(data.refresh_token)

                        // 设置登录用户信息
                        this.onGetUser().then(res => {
                            this.setSessionStorage(res)
                            this.$Spin.hide()
                            this.$router.push('/')
                        })
                    }else {
                        this.num++
                        this.bool = true
                        this.getCodes()
                        this.$Spin.hide()
                    }
                }).catch(err => {
                    this.$Spin.hide()
                    return false
                })
            }
        },
        mounted() {
            this.getCodes()
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

                        & > div:first-child {
                            .width(172px, 60px);
                            .flex(center, center);
                        }
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
