<template>
    <div class="Send-main">
        <v-title title="Change Your Password"></v-title>
        
        <section class="Send-main-block">
            <Form :model="formItem" ref="RulesItem" :rules="RulesItem">
                    <Row :gutter="20">
                        <Col span="7" class-name="Send-main-block-lable">
                            Current Password
                        </Col>
                        <Col span="17">
                            <FormItem prop="old_password">
                                <Input type="password" v-model="formItem.old_password" placeholder=""></Input>
                            </FormItem>
                        </Col>
                    </Row>
                    <Row :gutter="20">
                        <Col span="7" class-name="Send-main-block-lable">
                            New Password
                        </Col>
                        <Col span="17">
                            <FormItem prop="password">
                                <Input type="password" v-model="formItem.password" placeholder="Enter 6-20 characters（Case Sensitive A-Z，a-z，0-9 only）"></Input>
                            </FormItem>
                        </Col>
                    </Row>
                    <Row :gutter="20">
                        <Col span="7" class-name="Send-main-block-lable">
                            Confirm New Password
                        </Col>
                        <Col span="17">
                            <FormItem prop="password_confirmation">
                                <Input type="password" v-model="formItem.password_confirmation" placeholder="Enter 6-20 characters（Case Sensitive A-Z，a-z，0-9 only）"></Input>
                            </FormItem>
                        </Col>
                    </Row>
            </Form>
            <div class="Send-main-block-btn">
                <button @click="$router.back(-1)">Cancel</button>
                <button @click="onSave('RulesItem')">Save</button>
            </div>
        </section>
    </div>
</template>

<script>
    import Title from "../components/Title"
    import getData from "@/utils/getData"
    import upData from "@/utils/upData"

    export default {
        data () {
            const validatorReq = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('password is required'));
                }else {
                    callback()
                }
            }
            const validatorPassword = (rule, value, callback) => {
                // const Rex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/g
                const Rex = /^[a-zA-Z]\w{6,20}$/g
                let bool = Rex.test(value)
                if (value === '') {
                    callback(new Error('password is required'));
                } else if(!(value.length >= 6 && value.length <= 20)) {
                    callback(new Error('password must be between 6 and 20 characters'))
                } else if(!bool){
                    callback(new Error('password is (A-Z,a-z,0-9)'));
                }else {
                    callback()
                }
            }

            const validatorPasswords = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('password is required'));
                }else if(!(this.formItem.password === value)) {
                    callback(new Error("The two passwords don't match"))
                }else {
                    callback()
                }
            }

            return {
                formItem: {
                    old_password: '',
                    password: '',
                    password_confirmation: ''
                },
                RulesItem: { // 校验
                    old_password: [
                        { trigger: 'blur', validator: validatorReq }
                    ],
                    password: [ // 密码验证
                        { trigger: 'blur', validator: validatorPassword }
                    ],
                    password_confirmation: [ // 确认密码
                        { trigger: 'blur', validator: validatorPasswords }
                    ]
                },
            }
        },
        methods: {
            onChangePassword: upData.onChangePassword,
            onSave(name) {
                this.$refs[name].validate((valid) => {
                    if(valid) {
                        this.onChangePassword(this.formItem).then(res => {
                            this.$Message.success('Successful password modification')
                        })
                    }
                })
            }
        },
        mounted() {
            
        },
        components: {
            "v-title": Title,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .Send-main {
        .width(945px, 772px);
        .bg-color(white);
        padding: 21px 30px;

        &-block {
            width: 800px;
            height: 315px;
            margin-top: 160px;

            &-lable {
                font-size: 16px;
                color: #333333;
                text-align: right;
                height: 36px;
                line-height: 36px;
            }

            &-btn {
                margin-top: 70px;
                text-align: center;
                & > button {
                    width: 118px;
                    height: 44px;
                    background-color: #bfbfbf;
                    font-size: 18px;
                    color: #ffffff;
                    border: none;
                }

                 & > button:last-child {
                    background-color: #f0883a;
                    margin-left: 96px;
                }
            }
        }

    }
</style>
