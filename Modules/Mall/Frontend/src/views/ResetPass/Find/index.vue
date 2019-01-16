<template>
    <div class="resetPass">
        <main class="container">
            <div class="resetFind">
                <div class="resetFind-title">Reset Your Password</div>
                <section class="resetFind-block">
                    <div class="resetFind-block-title">Please enter the new password associated with your Afriby.com account.</div>
                    <dl class="resetFind-block-item">
                        <dd class="resetFind-block-item-list">
                            <div>Account</div>
                            <input type="text" placeholder="Please enter Member ID or Email Address" v-model="rulesFrom.username" v-verify="rulesFrom.username" />
                        </dd>
                        <dd class="resetFind-block-item-list">
                            <div>Verification Code</div>
                            <input type="text" placeholder="Please input verification code." v-model="rulesFrom.code" v-verify="rulesFrom.code" />
                            <div class="resetFind-block-item-list-code">
                                <Icon type="md-sync" size="28"/>
                            </div>
                        </dd>
                    </dl>
                    <button type="button" class="resetFind-block-btn" @click="onSubmit">Continue</button>
                </section>
            </div>
        </main>
        <v-Modal></v-Modal>
    </div>
</template>

<script>
    import FindModal from "../components/Find-Modal"

    export default {
        data() {
            return {
                rulesFrom: {
                    username: '',
                    code: ''
                },
            }
        },
        verify: {
            // 验证
            rulesFrom: {
                username: [
                    {
                        test: function (value) { // 自定义正则
                            if (value === '') {
                                return false
                            } else {
                                return true
                            }
                        },
                        message: 'Please enter your Email Address or Member ID.',
                    }
                ]
            }
        },
        methods: {
            onSubmit() {
                if(this.$verify.check()) {
                    this.$Message.info('true')

                    // setTimeout(() => {
                    //     this.$router.push('/')
                    // }, 3000)
                }else {
                    this.$Message.info('false')
                }
            },
        },
        components: {
            'v-Modal': FindModal
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');
    
    .resetPass {
        .flex(center,center);
        height: e("calc(100vh - 188px)");
        background-color: #f0f1f5;
    }

    .resetFind {
        .width(885px, 603px);
        .bg-color(white);
        margin: 0px auto;

        &-title {
            .lineHeight(90px);
            .bg-color(white);
            .color(blackDark);
            width: 885px;
            border-bottom: solid 1px #eeeeee;
            font-size: 20px;
            text-align: center;
            border-radius: 4px 4px 0px 0px;
        }

        &-block {
            .width(885px, 511px);
            .bg-color(white);
            .flex(center, center, column);
            border-radius: 0px 0px 4px 4px;

            &-title {
                .lineHeight(49px);
                .color(Orange);
                width: 652px;
                background-color: #fff8f3;
                border: solid 1px #f0883a;
                font-size: 16px;
                letter-spacing: 0px;
                text-align: center;
            }

            &-item {
                & > dd:first-of-type {
                    margin: 20px 0px;
                }

                & > dd:last-of-type {
                    margin: 40px 0px 50px 0px;
                }
                &-list {
                    .flex();
                    position: relative;

                    & > div:first-child {
                        .color(blackDark);
                        .lineHeight(60px);
                        width: 150px;
                        text-align: right;
                        padding-right: 20px;
                        font-size: 16px;
                    }

                    & > input:last-of-type {
                        .color(blackDark);
                        .width(505px, 60px);
                        border: solid 2px #eeeeee;
                        text-indent: 2em;
                        font-size: 16px;
                    }

                    &-code {
                        .flex(space-between, center);
                        .width(172px, 60px);
                        .bg-color(whiteLight);
                        position: absolute;
                        right: 0px;
                        cursor: pointer;
                        padding: 0px 15px;
                    }
                }
            }

            &-btn {
                .width(166px, 50px);
                .color(white);
                .bg-color(Orange);
                border: none;
                font-size: 18px;
            }
        }
    }
</style>
