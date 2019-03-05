<template>
    <div id="login">
        <header class="header">
            <img :src="require('@/assets/logo.png')" alt="">
        </header>

        <main class="main">
            <section class="main-block">
                <el-form  label-position="top" :model="ruleForm" status-icon :rules="rules2" ref="ruleForm" label-width="100px" class="main-block-form">
                    <el-form-item label="Username" prop="username">
                        <el-input type="text" v-model="ruleForm.username" size="small"></el-input>
                    </el-form-item>
                    <el-form-item label="Password" prop="password">
                        <el-input type="usernameword" v-model="ruleForm.password" size="small"></el-input>
                    </el-form-item>
                    <el-form-item prop="code">
                        <el-input v-model.number="ruleForm.code" style="width: 379px;" size="small"></el-input>
                        <div class="main-block-form-code">
                            <img src="" alt="">
                        </div>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" size="small" style="width: 100%;" @click="submitForm">Login</el-button>
                    </el-form-item>
                </el-form>
            </section>
        </main>

        <footer class="footer">
            Copyright © 2018-2019  Afriby.com  All Rights Reserved.
        </footer>
    </div>
</template>

<script>
    export default {
        data() {
            var validateUser = (rule, value, callback) => {
                if (value === '') {
                callback(new Error('Please enter your Email Address or Member ID.'))
                } else {
                if (this.ruleForm.password !== '') {
                    this.$refs.ruleForm.validateField('Please enter your Email Address or Member ID.')
                }
                callback();
                }
            }

            var validatePassword = (rule, value, callback) => {
                if (value === '') {
                callback(new Error('Incorrect Password.'))
                } else if (value !== this.ruleForm.username) {
                callback(new Error('Incorrect Password!'))
                } else {
                callback();
                }
            }

            return {
                ruleForm: {
                    username: '',
                    password: '',
                    code: ''
                },
                rules2: {
                    username: [
                        { validator: validateUser, trigger: 'blur' }
                    ],
                    password: [
                        { validator: validatePassword, trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            submitForm(formName) {
                // this.$refs[formName].validate((valid) => {
                // if (valid) {
                //     alert('submit!')
                // } else {
                //     return false;
                // }
                // });
                this.$router.push('/')
            }
        }
    }
</script>

<style lang="scss" scoped>
    #login {
        min-width: 1200px;

        .header {
            width: 100vw;
            min-width: 1200px;
            height: 88px;
            @include mixin-flex(flex-start, center);
            @include mixin-bg-color(white);

            & > img {
                width: 181px;
	            height: 53px;
                display: block;
                margin-left: 18.229vw;
            }
        }

        .main {
            width: 100vw;
            min-width: 1200px;
            height: calc(100vh - 88px - 100px);
            background: url('../../assets/login-bg.png') center center;
            position: relative;

            &-block {
                width: 600px;
                height: 459px;
                padding: 35px 43px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                box-sizing: border-box;
                @include mixin-bg-color(white);

                &-form {

                    &-code {
                        width: 134px;
                        height: 48px;
                        background-color: #eeeeee;
                        display: inline-block;
                        vertical-align: middle;
                        cursor: pointer;
                    }
                }
            }
        }

        .footer {
            width: 100vw;
            min-width: 1200px;
            height: 100px;
            font-size: 16px;
            @include mixin-flex(center, center);
            @include mixin-color(grey);
            @include mixin-bg-color(white);
            
        }
    }
</style>