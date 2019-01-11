<template>
    <div class="registered-main">
        <h1 class="registered-main-title">Create your Afriby.com account</h1>
        <div class="registered-main-info">Enter your account Information</div>
        
        <Form :model="formItem" label-position="left" :rules="ruleCustom" ref="ruleCustom" class="registered-main-form">
            <!-- 地区 -->
            <FormItem>
                <label for="" slot="label" class="label">Country/Region:</label>
                <Row>
                    <Col span="22">
                        <Select v-model="formItem.select" size="large">
                            <Option value="kenya">Kenya</Option>
                            <Option value="china">China</Option>
                        </Select>
                    </Col>
                    <!-- 国旗 -->
                    <Col span="2" style="text-align: center;">
                        <v-img width="47" height="34" :imgSrc="require('@/assets/img/china.png')" v-show="formItem.select == 'china'" style="float:right"></v-img>
                        <v-img width="47" height="34" :imgSrc="require('@/assets/img/kenya.png')" v-show="formItem.select == 'kenya'" style="float:right"></v-img>
                    </Col>
                </Row>
            </FormItem>
            <!-- 单选 -->
            <FormItem>
                <label for="" slot="label" class="label">Account Type:</label>
                <RadioGroup v-model="formItem.radio">
                    <Radio label="Supplier">Supplier</Radio>
                    <Radio label="Buyer" v-show="formItem.select == 'kenya'">Buyer</Radio>
                </RadioGroup>
            </FormItem>
            <!-- 账户 -->
            <FormItem prop="email">
                <label for="" slot="label" class="label">Email Address:</label>
                <Input v-model="formItem.email" placeholder="Please enter your Email Address." />
            </FormItem>
            <!-- 会员身份 -->
            <FormItem prop="MenberId">
                <label for="" slot="label" class="label">Menber ID:</label>
                <Input v-model="formItem.MenberId" placeholder="Member ID is the username,created by yourself.6-20 characters(A-Z,a-z,0-9,no spaces)." />
            </FormItem>
            <!-- 创建密码 -->
            <FormItem prop="password">
                <label for="" slot="label" class="label">Create Password：</label>
                <Input type="password" v-model="formItem.password" placeholder="6-20 characters(Case Sensitive A-Z,a-z,0-9,only)." />
            </FormItem>
            <!-- 确认密码 -->
            <FormItem prop="passwords">
                <label for="" slot="label" class="label">Confirm password:</label>
                <Input type="password" v-model="formItem.passwords" placeholder="Please enter your Password again." />
            </FormItem>
            <!-- 验证码 -->
            <FormItem>
                <label for="" slot="label" class="label">Verification code:</label>
                <Row>
                    <Col span="24">
                        <Col span="18">
                            <Input v-model="formItem.code" placeholder="Please enter verification code." />
                        </Col>
                        <!-- 国旗 -->
                        <Col span="6">
                            <div class="box-code-rex">
                                <div>
                                <img src="" alt="">
                                </div>
                                <Icon type="md-refresh" size="30"/>
                            </div>
                        </Col>
                    </Col>
                </Row>
            </FormItem>
            <!-- 邮箱验证码 -->
            <FormItem style="marginBottom:0px">
                <label for="" slot="label" class="label">Mailbox Verification code:</label>
                <Row>
                    <Col span="24">
                        <Col span="18">
                            <Input v-model="formItem.emailCode" placeholder="Please enter the email verification code." />
                        </Col>
                        <Col span="6">
                            <div class="registered-main-form-btn">Send</div>
                        </Col>
                    </Col>
                </Row>
            </FormItem>
            <!-- 协议 -->
            <FormItem>
                <Checkbox v-model="formItem.checkRadio"></Checkbox>
                <span>I have read and agree <router-link to="" id="registered-main-form-link">service agreement</router-link></span>
            </FormItem>
            <!-- 提交 -->
            <FormItem style="marginTop:46px;">
                <Button type="primary" @click="onSubmit('ruleCustom')" class="subBtn">Create My Account</Button>
            </FormItem>
        </Form>
    </div>
</template>

<script>
    import Img from "@/components/Img"

    export default {
        data() {
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

            const validatorPassword = (rule, value, callback) => {
                const Rex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/g
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
            };

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
                    select: 'kenya', // 地区
                    radio: 'Supplier', // 单选
                    email: '', // 账户
                    MenberId: '', // 会员身份
                    password: '', // 创建密码
                    passwords: '', // 确认密码
                    code: '', // 验证码
                    emailCode: '', // 邮箱验证码
                    checkRadio: false, // 协议
                },

                ruleCustom: {
                    email: [ // 邮箱验证
                        { trigger: 'blur', type: "email" }
                    ],
                    MenberId: [ // Id验证
                        { trigger: 'blur', validator: validatorMenberId }
                    ],
                    password: [ // 密码验证
                        { trigger: 'blur', validator: validatorPassword }
                    ],
                    passwords: [ // 确认密码
                        { trigger: 'blur', validator: validatorPasswords }
                    ],
                }
            }
        },
        methods: {
            onSubmit(name) { // 下一步
                if(this.formItem.checkRadio) {
                    this.$refs[name].validate((valid) => {
                        this.$router.push('/registered/two')
                    })
                }else {
                    this.$Message.warning('请阅读协议')
                }
            }
        },
        components: {
            'v-img': Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

    .registered-main {
        .width(768px, auto);
        .bg-color(white);
        padding: 0px 54px 44px 54px;

        &-title {
            .color(blackDark);
            height: 24px;
            font-size: 24px;
            line-height: 1;
            margin-top: 50px;
            text-align: center;
            font-weight: bold;
        }

        &-info {
            .color(blackDark);
            height: 17px;
            font-size: 18px;
            line-height: 1;
            margin-top: 37px;
            margin-bottom: 24px;
        }

        .registered-main-form-item {
            .flex(flex-start, flex-start, column);
        }

        & > &-form {
            .label {
                .color(blackDark);
                width: 660px;
                height: 15px;
                font-size: 16px;
                line-height: 1;
            }
            #registered-main-form-link {
                .color(Orange);
                text-decoration: underline;
            }
            .subBtn {
                .color(white);
                .bg-color(Orange);
                .width(100%, 61px);
                font-size: 21px;
                border-color: transparent;
            }

            
        
        }
        .box-code-rex {
            .width(100%, 36px);
            .flex(space-between, center);
            .bg-color(whiteLight);
            padding: 0px 15px;
        }

        .registered-main-form-btn {
            .width(100%, 36px);
            .color(white);
            .bg-color(Orange);
            line-height: 36px;
            text-align: center;
            font-size: 21px;
            cursor: pointer;
        }
    }
</style>
