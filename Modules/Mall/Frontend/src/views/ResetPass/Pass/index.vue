<template>
     <div class="resetPass">
        <main class="container">
            <div class="resetPass-box">
                <div class="resetPass-box-title">Reset Your Password</div>
                <section class="resetPass-box-block">
                    <div class="resetPass-box-block-title">Please enter the new password associated with your Afriby.com account.</div>
                    <dl class="resetPass-box-block-item">
                        <dd class="resetPass-box-block-item-list">
                            <div>Member ID</div>
                            <div class="resetPass-box-block-item-list-last">{{ member_id }}</div>
                        </dd>
                        <dd class="resetPass-box-block-item-list">
                            <div>New Password</div>
                            <input type="password" placeholder="Enter 6-20 characters（Case Sensitive A-Z，a-z，0-9 only）" v-model="rulesFrom.password" v-verify="rulesFrom.password" />
                            <div class="resetPass-box-block-item-list-title" v-remind="rulesFrom.password">Enter 6-20 characters（Case Sensitive A-Z，a-z，0-9 only）</div>
                        </dd>
                        <dd class="resetPass-box-block-item-list">
                            <div>Confirm New Password</div>
                            <input type="password" placeholder="Enter 6-20 characters（Case Sensitive A-Z，a-z，0-9 only）" v-model="rulesFrom.passwordCheck" v-verify="rulesFrom.passwordCheck" />
                            <div class="resetPass-box-block-item-list-title" v-remind="rulesFrom.passwordCheck">Enter 6-20 characters（Case Sensitive A-Z，a-z，0-9 only）</div>
                        </dd>
                    </dl>
                    <button type="button" class="resetPass-box-block-btn" @click="onSubmit">Submit</button>
                </section>
            </div>
        </main>
        <!-- 模态框 -->
        <v-modal v-show="bool"></v-modal>
    </div>
</template>

<script>
    import Modal from '../components/Modal'
    import getData from "@/utils/getData"
    import upData from "@/utils/upData"

    export default {
        data() {
            return {
                rulesFrom: {
                    password: '',
                    passwordCheck: ''
                },
                token: '',
                member_id: '',
                bool: false
            }
        },
        verify: {
            // 验证
            rulesFrom: {
                password: [
                    {
                        test: function (value) { // 自定义正则
                            // const Rex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/g
                            const Rex = /^[a-zA-Z]\w{6,20}$/g
                            let bool = Rex.test(value)

                            if (value === '') {
                                return false
                            } else if(!(value.length >= 6 && value.length <= 20)) {
                                return false
                            } else if(!bool){
                                return false
                            }else {
                                return true
                            }
                        },
                        message: 'Enter 6-20 characters（Case Sensitive A-Z，a-z，0-9 only）',
                    }
                ],
                passwordCheck: [
                    {
                        test: function (value) { // 自定义正则
                            if (value === '') {
                                return false
                            }else if(!(this.rulesFrom.password === value)) {
                                return false
                            }else {
                                return true
                            }
                        },
                        message: 'Enter 6-20 characters（Case Sensitive A-Z，a-z，0-9 only）',
                    }
                ]
            }
        },
        methods: {
            UpResetPass: upData.UpResetPass,
            onGetNumId: getData.onGetNumId,
            onSubmit() {
                if(this.$verify.check()) {
                    this.UpResetPass({
                        token: this.token,
                        password: this.rulesFrom.password,  //新密码
                        password_confirmation: this.rulesFrom.passwordCheck  //新重复密码
                    }).then(res => {
                        this.bool = true
                    })
                }
            },
        },
        mounted() {
            this.token = this.$route.query.token
            this.onGetNumId(this.token).then(res => {
                this.member_id = res.member_id
            })
        },
        components: {
            'v-modal': Modal
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .resetPass {
        .flex(center,center);
        height: e("calc(100vh - 188px)");
        background-color: #f0f1f5;

        .resetPass-box {
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
                .width(885px, 516px);
                .bg-color(white);
                .flex(center, center, column);
                border-radius: 0px 0px 4px 4px;

                &-title {
                    .lineHeight(49px);
                    .color(Orange);
                    width: 590px;
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
                            width: 200px;
                            text-align: right;
                            padding-right: 20px;
                            font-size: 16px;
                        }

                        &-last {
                            .color(blackDark);
                            .lineHeight(60px);
                            width: 563px;
                            font-size: 16px;
                        }

                        & > input:last-of-type {
                            .color(blackDark);
                            .width(563px, 60px);
                            border: solid 2px #eeeeee;
                            text-indent: 2em;
                            font-size: 16px;
                        }

                        &-title {
                            position: absolute;
                            bottom: -25px;
                            left: 200px;
                            .color(red);
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
    }
</style>
