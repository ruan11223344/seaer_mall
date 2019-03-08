<template>
    <div class="jurisdiction">
        <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="70px" class="demo-ruleForm">
            <el-form-item label="登录名" prop="admin_name">
                <el-input type="text" v-model="ruleForm.admin_name" style="max-width: 560px;"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="password">
                <el-input type="password" v-model="ruleForm.password" style="max-width: 560px;"></el-input>
            </el-form-item>
            <el-form-item label="确认密码" prop="password_confirmation">
                <el-input type="password" v-model="ruleForm.password_confirmation" style="max-width: 560px;"></el-input>
            </el-form-item>
            <el-form-item label="权限组" prop="role_id">
                <template>
                    <el-select v-model="ruleForm.role_id" placeholder="请选择" style="width: 100%; max-width: 560px;">
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
            const validate = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请输入内容'))
                }else {
                    callback()
                }
            }

            const validatorCheck = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请确认密码'))
                }else if (value !== this.ruleForm.password) {
                    callback(new Error('两次密码不一致'))
                }else {
                    callback()
                }
            }

            const validateSelect = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请选择权限组'))
                }else {
                    callback()
                }
            }
            
            return {
                options: [],
                value: '',
                ruleForm: {
                    admin_name: '',
                    password: '',
                    password_confirmation: '',
                    role_id: ''
                },
                rules: {
                    admin_name: [
                        { validator: validate, trigger: 'blur' }
                    ],
                    password: [
                        { validator: validate, trigger: 'blur' }
                    ],
                    password_confirmation: [
                        { validator: validatorCheck, trigger: 'blur' }
                    ],
                    role_id: [
                        { validator: validateSelect, trigger: 'blur' }
                    ]
                }
            };
        },
        methods: {
            // 创建管理员
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        const admin_id = this.$route.query.admin_id
                        if(admin_id != undefined) {
                            this.onEdit(admin_id)
                        }else {
                            this.onEstablish()
                        }
                    } else {
                        return false
                    }
                })
            },
            // 创建
            onEstablish() {
                this.$PutRequest.putAddAdmin(this.ruleForm)
                    .then(res => {
                        this.$router.go(-1)
                    }
                ).catch(err => {
                        this.$message({
                            showClose: true,
                            message: err.message,
                            type: 'error'
                        })
                    }
                )
            },
            onEdit(admin_id) {
                this.$PutRequest.putEditAdmin({
                    admin_id: admin_id,  //必填 管理员id
                    admin_name: this.ruleForm.admin_name,
                    password:  this.ruleForm.password,
                    role_id:  this.ruleForm.role_id
                })
                    .then(res => {
                        this.$router.go(-1)
                    }
                ).catch(err => {
                        this.$message({
                            showClose: true,
                            message: err.message,
                            type: 'error'
                        })
                    }
                )
            },
            // 8.获取权限组列表
            onGetJurisdiction() {
                this.$GetRequest.getJurisdictionList()
                    .then(res => {
                        for(let i = 0; i < res.length; i++) {
                            this.options.push({ value: res[i].role_id, label: res[i].role_name })
                        }
                    }
                )
            }
        },
        mounted() {
            this.onGetJurisdiction()
        },
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
