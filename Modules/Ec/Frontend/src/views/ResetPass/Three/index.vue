<template>
    <div class="resetPass">
        <main class="resetPass-main">
            <div class="box">
                <h1>Please enter the new password associcated with your Afriby.com account</h1>
                <div class="box-title">Registered Email Address:  5214456513@qq.com</div>
                <div class="box-title">New Password:</div>
                <!-- 用户id -->
                <section class="box-useId">
                    <!-- 新密码 -->
                    <input type="text" placeholder="Please enter 6-20 characters(A-Z,a-z,0-9 only)" v-model="rulesFrom.userId" v-verify="rulesFrom.userId">
                    <div class="box-useId-prompt" v-remind="rulesFrom.userId"></div>
                </section>
                <section class="box-useId box-code" style="marginTop: 40px;">
                    <div class="box-title">Re-enter New Password:</div>
                    <!-- 确认密码 -->
                    <input type="text" placeholder="Please enter 6-20 characters(A-Z,a-z,0-9 only)" v-model="rulesFrom.password" v-verify="rulesFrom.password">
                    <div class="box-useId-prompt" v-remind="rulesFrom.password">Incorrect captcha.please enter the text in the image.</div>
                </section>
                <div class="box-btn" @click="onSubmit" id="Login-btn">Continue</div>
            </div>
        </main> 
    </div>
</template>

<script>
    import Verify from 'vue2-verify'

    export default {
        name: 'app',
        data() {
            return {
                rulesFrom: {
                    userId: '',
                    password: ''
                },
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
                    // this.$Message.info('3秒后跳转到首页')

                    // setTimeout(() => {
                    //     this.$router.push('/')
                    // }, 3000)
                }
            },
        },
        mounted() {
        },
        components: {
            Verify,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .resetPass {
        &-main {
            height: e("calc(100vh - 188px)");
            background-color: #f0f1f5;

            .box {
                .width(770px, 589px);
                padding-top: 51px;
                padding-left: 52px;
                padding-right: 52px;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -51.6%);
                position: relative;

                & > h1 {
                    .width(600px, 51px);
                    .color(blackDark);
                    margin: 0px auto;
                    font-size: 22px;
                    font-weight: bold;
                    line-height: 1.2;
                    margin-bottom: 39px;
                    text-align: center;
                }
                &-title {
                    .lineHeight(37px);
                    .flex(space-between, center);
                    .color(blackDark);
                    width: 660px;
                    letter-spacing: 0px;
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
    }
        
</style>
