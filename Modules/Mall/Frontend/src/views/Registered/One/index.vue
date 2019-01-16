<template>
    <section class="container Registered-one">

        <v-head-template :img="require('@/assets/img/login/bg1.png')" />

        <div class="Registered-one-main">
            <Form ref="formCustom" :model="formCustom" :rules="ruleCustom" label-position="right" :label-width="120">
                <!-- id -->
                <FormItem prop="id">
                    <label for="" slot="label" class="Registered-one-main-label">Menber ID</label>
                    <Input type="text" v-model="formCustom.id" placeholder="Member ID is the username,created by yourself." />
                </FormItem>
                <!-- 邮箱 -->
                <FormItem prop="email">
                    <label for="" slot="label" class="Registered-one-main-label">Email Address</label>
                    <Input v-model="formCustom.email" placeholder="Please enter your Email Address." />
                </FormItem>
                <!-- 验证码 -->
                <FormItem prop="code">
                    <label for="" slot="label" class="Registered-one-main-label">Verification</label>
                    <Row>
                        <Col span="16">
                            <Input type="text" v-model="formCustom.age" number />
                        </Col>
                        <Col span="8">
                            <div class="Registered-one-main-code">
                                <div></div>
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
                formCustom: {
                    id: '',
                    email: '',
                    code: '',
                    single: false,
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
        methods: {
            handleSubmit (name) {
                if(this.formCustom.single) {
                    this.$refs[name].validate((valid) => {
                        if (valid) {
                            this.$Message.success('Success!');
                        } else {
                            this.$Message.error('Fail!');
                        }
                    })
                }else {
                    this.$Message.error('code!');
                }
            },
        },
        mounted() {
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
                .flex(space-between);
                cursor: pointer;
                width: 100%;
                height: 36px;
                background-color: #eeeeee;
                padding: 0px 15px;
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
