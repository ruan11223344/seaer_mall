<template>
    <div id="admin">
        <section class="title">
            <div :class="active == 0 ? 'active' : ''" @click="active = 0">管理员列表</div>
            <div :class="active == 1 ? 'active' : ''" @click="active = 1">权限组列表</div>
        </section>

        <section v-show="active == 0">
            <button class="add" @click="onAdd">+新增</button>

            <template>
                <el-table
                    ref="singleTable"
                    :data="AdminData"
                    style="width: 100%"
                    size="mini"
                    >

                    <el-table-column
                        align="center"
                        label="序号"
                        property="num"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="admin_name"
                        label="登录名"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="last_login"
                        label="上次登录时间"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="login_count"
                        label="登录次数"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="role_name"
                        label="权限组"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        label="操作"
                        width="200px"
                        >
                        <template slot-scope="scope">
                            <button
                                class="del"
                                @click="handleEdit(scope.$index, scope.row)"
                                >
                                删除
                            </button>
                            <button
                                class="edit"
                                @click="handleEdit(scope.$index, scope.row)"
                                >
                                编辑
                            </button>
                        </template>
                    </el-table-column>
                </el-table>
            </template>

            
        </section>

        <section v-show="active == 1">
            <button class="Jurisdiction" @click="onJurisdiction">+新增权限组</button>

            <template>
                <el-table
                    ref="singleTable"
                    :data="jurisdiction"
                    style="width: 100%"
                    size="mini"
                    >

                    <el-table-column
                        align="center"
                        label="序号"
                        width="150px"
                        property="role_id"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="role_name"
                        label="权限组"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        label="操作"
                        width="200px"
                        >
                        <template slot-scope="scope">
                            <button
                                class="del"
                                @click="handleEdit(scope.$index, scope.row)"
                                >
                                删除
                            </button>
                            <button
                                class="edit"
                                @click="handleEdit(scope.$index, scope.row)"
                                >
                                编辑
                            </button>
                        </template>
                    </el-table-column>
                </el-table>
            </template>
        </section>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                active: 0,
                AdminData: [],
                jurisdiction: [],
                total: {
                    total: 0,
                    size: 18,
                    num: 1
                }
            };
        },
        methods: {
            onAdd() {
                this.$router.push('/admin/add')
            },
            onJurisdiction() {
                this.$router.push('/admin/jurisdiction')
            },
            handleEdit(tab, event) {
                // console.log(tab, event);
            },
            onGetJurisdiction() {
                this.$GetRequest.getJurisdictionList()
                    .then(res => {
                        this.jurisdiction = res
                    }
                )
            },
            onGetAdmin() {
                this.$GetRequest.getAdminList(this.total.size, this.total.num)
                    .then(res => {
                        console.log(res)
                        this.AdminData = res.data
                    }
                ).catch(err => {
                        this.$message({
                            message: err.message,
                            type: 'success'
                        })
                    }
                )
            },
            onClcik(num) {
                switch (num) {
                    case 0:
                        this.onGetAdmin()
                        break
                    case 1:
                        this.onGetJurisdiction()
                        break
                    default:
                        break
                }
            }
        },
        mounted() {
            this.onClcik(this.active)
        },
        watch: {
            active(newVal) {
                this.onClcik(newVal)
            }
        },
    }
</script>

<style lang="scss" scoped>
    $--title--height: 40px;

    #admin {
        width: 100%;

        .title {
            width: 100%;
            height: $--title--height;
            padding-left: 20px;
            box-sizing: border-box;
            @include mixin-bg-color(lead);
            @include mixin-flex(flex-start, center);

            & > div {
                height: $--title--height;
                line-height: $--title--height;
                font-size: 14px;
                margin-right: 56px;
                position: relative;
                cursor: pointer;
                @include mixin-color(grey);
            }

            & > div.active {
                &::before {
                    content: '';
                    width: 52px;
                    height: 1px;
                    background-color: #f0883a;
                    position: absolute;
                    left: 50%;
                    bottom: 0px;
                    transform: translateX(-50%);
                }
            }
        }

        .add {
            font-size: 16px;
            width: 71px;
            height: 25px;
            border: none;
            margin-top: 16px;
            margin-bottom: 10px;
            @include mixin-color(white);
            @include mixin-bg-color(yellow);
        }

        .del {
            @include mixin-btn;
            border: solid 1px #f0883a;
            @include mixin-color(yellow);
            @include mixin-bg-color(white);
        }

        .edit {
            margin-left: 12px;
            @include mixin-btn;
            @include mixin-color(white);
            @include mixin-bg-color(yellow);
        }

        .Jurisdiction {
            width: 119px;
            height: 25px;
            font-size: 16px;
            border: none;
            margin-top: 16px;
            margin-bottom: 10px;
            @include mixin-color(white);
            @include mixin-bg-color(yellow);
        }
    }
</style>
