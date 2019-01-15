<template>
    <section class="container Registered-one">

        <v-head-template :img="require('@/assets/img/login/bg1.png')" />

        <div class="Registered-one-main">
            <Form ref="formCustom" :model="formCustom" :rules="ruleCustom" label-position="right" :label-width="120">
                <FormItem prop="id">
                    <label for="" slot="label" class="Registered-one-main-label">Menber ID</label>
                    <Input type="password" v-model="formCustom.passwd" placeholder="Member ID is the username,created by yourself." />
                </FormItem>
                <FormItem prop="email">
                    <label for="" slot="label" class="Registered-one-main-label">Email Address</label>
                    <Input type="password" v-model="formCustom.passwdCheck" />
                </FormItem>
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
                        <Checkbox v-model="single">
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
            const validatePass = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('Please enter your password'));
                } else {
                    if (this.formCustom.passwdCheck !== '') {
                        // 对第二个密码框单独验证
                        this.$refs.formCustom.validateField('passwdCheck');
                    }
                    callback();
                }
            };
            const validatePassCheck = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('Please enter your password again'));
                } else if (value !== this.formCustom.passwd) {
                    callback(new Error('The two input passwords do not match!'));
                } else {
                    callback();
                }
            };
            const validateAge = (rule, value, callback) => {
                if (!value) {
                    return callback(new Error('Age cannot be empty'));
                }
                // 模拟异步验证效果
                setTimeout(() => {
                    if (!Number.isInteger(value)) {
                        callback(new Error('Please enter a numeric value'));
                    } else {
                        if (value < 18) {
                            callback(new Error('Must be over 18 years of age'));
                        } else {
                            callback();
                        }
                    }
                }, 1000);
            };
            
            return {
                single: false,
                formCustom: {
                    id: '',
                    email: '',
                    code: ''
                },
                ruleCustom: {
                    id: [
                        { validator: validatePass, trigger: 'blur' }
                    ],
                    email: [
                        { validator: validatePassCheck, trigger: 'blur' }
                    ],
                    code: [
                        { validator: validateAge, trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Message.success('Success!');
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
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
