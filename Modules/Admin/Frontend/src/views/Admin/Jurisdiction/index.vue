<template>
    <div id="jurisdiction">
        <el-form :model="formLabelAlign">
            <el-form-item>
                <span slot="label">权限组</span>
                <el-input v-model="formLabelAlign.role_name" style="width: 100%; max-width: 560px;"></el-input>
            </el-form-item>
            <el-form-item>
                <span slot="label">权限组</span>
                <el-checkbox v-model="formLabelAlign.all_permissions">所有权限</el-checkbox>
                <span>(勾选后选中全部操作功能，可根据需要从设置详情中进行分组设置)</span>
            </el-form-item>
        </el-form>

        <div class="hr"></div>

        <div class="title">权限操作设置详情</div>

        <div class="block">
            全部权限
        </div>
        <section class="group">
            <template>
                <el-checkbox-group 
                    v-model="formLabelAlign.permissions_list"
                    >
                    <el-checkbox
                        v-for="(city, index) in cities"
                        :label="city.permission_id"
                        :key="index" 
                        class="group-checkbox"
                        >{{ city.display_name }}
                    </el-checkbox>
                </el-checkbox-group>
            </template>
        </section>

        <!-- <div class="block" style="margin-top: 35px;">
            <el-checkbox v-model="checked">商城模块功能</el-checkbox>
        </div>
        <section class="group">
            <template>
                <el-checkbox-group 
                    v-model="checkedCities2"
                    >
                    <el-checkbox
                        v-for="(city, index) in cities"
                        :label="city.display_name"
                        :key="index" 
                        class="group-checkbox"
                        >{{city.display_name}}
                    </el-checkbox>
                </el-checkbox-group>
            </template>
        </section> -->

        <el-button type="primary" class="sub" @click="onSub">保存</el-button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                formLabelAlign: {
                    role_name: '',
                    all_permissions: false,
                    permissions_list: []
                },
                checked: false,
                // checkedCities2: [],
                cities: []
            }
        },
        methods: {
            // 保存
            onSub() {
                const role_id = this.$route.query.role_id

                if(role_id != undefined) {
                    this.onEdit(role_id)
                }else {
                    this.onEstablish()
                }
            },
            // 权限组创建
            onEstablish() {
                this.$PutRequest.putAddRole(this.formLabelAlign)
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
            // 编辑
            onEdit(role_id) {
                this.$PutRequest.putEditRole({
                    role_id: role_id,  //必填 管理员id
                    role_name: this.formLabelAlign.role_name,
                    all_permissions:  this.formLabelAlign.all_permissions,
                    permissions_list:  this.formLabelAlign.permissions_list
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
            // 获取所有权限列表
            GetPermissions() {
                this.$GetRequest.getPermissionsList()
                    .then(res => {
                        this.cities = res
                    })
                    .catch(err => {
                        this.$message.error(err.message)
                    })
            },
            // 获取已有权限列表
            GetRoleList() {
                const role_name = this.$route.query.role_name

                this.$set(this.formLabelAlign, 'role_name', role_name)
                this.formLabelAlign.permissions_list = []
                this.$GetRequest.getRolePermissions(this.$route.query.role_id)
                    .then(({ has_all_permission, permission_list }) => {
                        this.$set( this.formLabelAlign, 'all_permissions', has_all_permission )
                        permission_list.forEach(({ permission_id }) => {
                            if(!this.formLabelAlign.permissions_list.includes(permission_id)) {
                                this.formLabelAlign.permissions_list.push(permission_id)
                            }
                        })
                    })
                    .catch(err => {
                        this.$message.error(err.message)
                    })
            }
        },
        mounted() {
            this.GetPermissions()

            if(this.$route.query.role_id != undefined) {
                    this.GetRoleList()
                }
        },
        watch: {
            '$route': function () {
                if(this.$route.query.role_id != undefined) {
                    this.GetRoleList()
                }
            }
        },
    }
</script>

<style lang="scss" scoped>
    #jurisdiction {
        margin-top: 50px;

        .hr {
            width: 100%;
            height: 1px;
            margin: 40px auto;
            background-color: #eeeeee;
        }

        .title {
            font-size: 18px;
            @include mixin-color(grey);
        }

        .block {
            width: 100%;
            height: 47px;
            margin-top: 16px;
            padding-left: 23px;
            box-sizing: border-box;
            @include mixin-flex(flex-start, center);
            @include mixin-bg-color(lead);
        }

        .group {
            padding-left: 23px;

            &-checkbox {
                margin-top: 35px;
            }
        }

        .sub {
            width: 107px;
            margin: 0px auto;
            margin-top: 50px;
            display: block;
        }
    }
</style>