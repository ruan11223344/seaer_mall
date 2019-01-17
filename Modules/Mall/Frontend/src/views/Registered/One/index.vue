<template>
    <section class="container Registered-one">

        <v-head-template :img="require('@/assets/img/login/bg1.png')" />

        <div class="Registered-one-main">
            <Form ref="formCustom" :model="formCustom" :rules="ruleCustom" label-position="right" :label-width="120">
                <!-- id -->
                <FormItem prop="id">
                    <label for="" slot="label" class="Registered-one-main-label">Menber ID</label>
                    <Input type="text" v-model="formCustom.id" :placeholder="Countries ? 'Member ID is the username,created by yourself.'  : '请输入您的ID'" />
                </FormItem>
                <!-- 邮箱 -->
                <FormItem prop="email">
                    <label for="" slot="label" class="Registered-one-main-label">Email Address</label>
                    <Input v-model="formCustom.email" :placeholder="Countries ? 'Please enter your Email Address.' : '请输入您的邮箱地址'" />
                </FormItem>
                <!-- 验证码 -->
                <FormItem prop="code">
                    <label for="" slot="label" class="Registered-one-main-label">Verification</label>
                    <Row>
                        <Col span="16">
                            <Input type="text" v-model="formCustom.code" />
                        </Col>
                        <Col span="8">
                            <!-- 验证码 -->
                            <div class="Registered-one-main-code" @click="getCode">
                                <div>
                                    <img :src="imgCode" />
                                </div>
                                <div>
                                    <Icon type="md-sync" size="26"/>
                                </div>
                            </div>
                        </Col>
                    </Row>
                </FormItem>
                <FormItem>
                    <div>
                        <Checkbox v-model="formCustom.single">
                            I have read and agree <router-link to="" class="Registered-one-main-single">service agreement</router-link>
                        </Checkbox>
                    </div>
                </FormItem>
                <FormItem>
                    <button class="Registered-one-main-btn" type="button" @click="handleSubmit('formCustom')">Create My Account</button>
                </FormItem>
            </Form>
        </div>
    </section>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'
    import Img from "@/components/Img"
    import HeadTemplate from "../components/Head/index"

    export default {
        data () {
            const validatorMenberId = (rule, value, callback) => {
                const Rex = /^[\da-zA-Z]{6,20}$/g
                let bool = Rex.test(value)

                if (value === '') {
                    callback(new Error('MenberId is required'));
                } else if(!(value.length >= 6 && value.length <= 20)) {
                    callback(new Error('MenberId must be between 6 and 20 characters'))
                } else if(!bool){
                    callback(new Error('MenberId is (A-Z,a-z,0-9)'));
                }else {
                    callback()
                }
            };

            const validatorEmail = (rule, value, callback) => {
                const Rex = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/gi
                let bool = Rex.test(value)
                if (value === '') {
                    callback(new Error('Email is required'));
                }else if(!bool){
                    callback(new Error('email is not a valid email'));
                }else {
                    callback()
                }
            };

            return {
                imgCode: '',
                formCustom: {
                    id: '',
                    email: '',
                    code: '',
                    single: false,
                    key: ''
                },
                ruleCustom: {
                    id: [
                        { validator: validatorMenberId, trigger: 'blur' }
                    ],
                    email: [ // 邮箱验证
                        {  validator: validatorEmail, trigger: 'blur' }
                    ]
                }
            }
        },
        computed: {
            ...mapState([ 'Countries' ])
        },
        methods: {
            ...mapMutations(['SET_REGEMAIL']),
            // 下一步
            handleSubmit (name) {
                if(this.formCustom.single) {
                    this.$refs[name].validate((valid) => {
                        if (valid) {
                            this.updateFrom()
                        } else {
                            this.$Message.error('Fail!');
                        }
                    })
                }else {
                    this.$Message.error('Read the Service Agreement!');
                }
            },
            getCode() {  // 获取验证码
                this.$request({
                    url: '/utils/get_captcha'
                }).then( ({ code, data }) => {
                    if(code == 200) {
                        this.imgCode = data.img
                        this.formCustom.key = data.key
                    }else {
                        this.$Message.warning('error: 400')
                    }
                }).catch(err => {
                    return false
                })
            },
            updateFrom() { // 发送表单
                this.$request({
                    url: '/auth/send_register_email',
                    method: 'post',
                    data: {
                        member_id: this.formCustom.id, // 用户名
                        captcha: this.formCustom.code, // 验证码
                        key: this.formCustom.key,
                        email: this.formCustom.email,
                        account_type: this.Countries, // 账户类型
                        i_agree: this.formCustom.single // 同意协议
                    }
                }).then( res => {
                    this.getCode()
                    const { code, data} = res
                    if(code == 200) {
                        // 把注册的邮箱存入vuex
                        this.SET_REGEMAIL({ Email: this.formCustom.email, redirect_to: data.redirect_to})
                        this.$router.push('/registered/two')
                    }else {
                        this.$Message.warning('Verification code error, please input the correct verification code')
                    }
                }).catch(err => {
                    return false
                })
            }
        },
        mounted() {
            this.getCode()
        },
        components: {
            'v-img': Img,
            'v-head-template': HeadTemplate
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

    .Registered-one {

        &-main {
            width: 900px;
            height: 510px;
            background-color: #ffffff;
            border-radius: 4px;
            border: solid 1px #eeeeee;
            margin: 0px auto;
            margin-top: 20px;
            padding: 100px 150px;
            
            &-label {
                font-size: 16px;
                line-height: 1;
                letter-spacing: 0px;
                color: #333333;
            }

            &-code {
                .flex(flex-start, center, row);
                cursor: pointer;
                width: 100%;
                height: 36px;
                background-color: #eeeeee;

                & > div:first-child {
                    width: 120px;
                    height: 36px;
                    margin-right: 5px;

                    & > img {
                        width: 100%;
                        height: 100%;
                        display: block;
                    }
                }
            }

            &-single {
                text-decoration: underline;
                font-size: 16px;
                letter-spacing: 0px;
                color: #f0883a;
            }

            &-btn {
                width: 198px;
                height: 50px;
                background-color: #f0883a;
                border: none;
                margin-left: 80px;
                font-size: 18px;
                line-height: 1;
                letter-spacing: 0px;
                color: #ffffff;
            }
        }
        
    }
</style>
