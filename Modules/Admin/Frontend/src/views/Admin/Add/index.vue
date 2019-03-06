<template>
    <div class="jurisdiction">
        <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="70px" class="demo-ruleForm">
            <el-form-item label="登录名" prop="user">
                <el-input type="text" v-model="ruleForm.user" style="max-width: 560px;"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="password">
                <el-input type="password" v-model="ruleForm.password" style="max-width: 560px;"></el-input>
            </el-form-item>
            <el-form-item label="确认密码" prop="checkPassword">
                <el-input type="password" v-model="ruleForm.checkPassword" style="max-width: 560px;"></el-input>
            </el-form-item>
            <el-form-item label="权限组" prop="jurisdiction">
                <template>
                    <el-select v-model="ruleForm.jurisdiction" placeholder="请选择" style="width: 100%; max-width: 560px;">
                        <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                            >
                        </el-option>
                    </el-select>
                </template>
                <div>请选择一个权限组，如果还未设置，请先建立权限组后再添加管理员。</div>
            </el-form-item>
        </el-form>

        <el-button type="primary" @click="submitForm('ruleForm')" class="sub">确认提交</el-button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                options: [
                    {
                        value: '1',
                        label: '一级管理员'
                    },
                    {
                        value: '2',
                        label: '二级管理员'
                    }
                ],
                value: '',
                ruleForm: {
                    user: '',
                    password: '',
                    checkPassword: '',
                    jurisdiction: ''
                },
                rules: {

                }
            };
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        alert('submit!')
                    } else {
                        return false
                    }
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .jurisdiction {
        margin-top: 70px;
        @include mixin-flex(center, center, column);
    }

    .sub {
        width: 118px;
        height: 44px;
        background-color: #f0883a;
        margin: 0px auto;
        margin-top: 30px;
        display: block;
    }
</style>
