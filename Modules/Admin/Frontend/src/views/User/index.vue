<template>
    <el-main id="user">
        <section class="title">
            <div class="title-left">
                <span>用户列表</span>
                <span>共2000条</span>
            </div>

            <div class="title-right">
                <el-input placeholder="请输入“会员ID”、“Email”搜索相关数据" v-model="search" class="title-right-input">
                    <el-button type="primary" slot="append" icon="el-icon-search" class="title-right-search"></el-button>
                </el-input>
            </div>
        </section>

        <template>
            <el-table
                ref="singleTable"
                :data="tableData"
                style="width: 100%"
                >

                <el-table-column
                    align="center"
                    label="序号"
                    type="index"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="date"
                    label="注册时间"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="name"
                    label="AF ID"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="name"
                    label="会员ID"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="name"
                    label="会员邮箱"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="name"
                    label="联系人姓名"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="name"
                    label="性别"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="name"
                    label="手机号"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="name"
                    label="地址"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="name"
                    label="最后登录时间"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    label="允许询盘"
                    >
                    <template slot-scope="scope">
                        <button
                            class="edit"
                            @click="handleEdit(scope.$index, scope.row)"
                            >
                            允许
                        </button>
                    </template>
                </el-table-column>
            </el-table>
        </template>

        <section class="page">
            <el-pagination
                background
                layout="prev, pager, next"
                :total="1000"
                >
            </el-pagination>
        </section>
    </el-main>
</template>

<script>
    export default {
        data() {
            return {
                search: null,
                tableData: [
                    {
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                    },
                    {
                    date: '2016-05-04',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1517 弄'
                    },
                    {
                    date: '2016-05-01',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1519 弄'
                    },
                    {
                    date: '2016-05-03',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1516 弄'
                    },
                    {
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                    },
                    {
                    date: '2016-05-04',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1517 弄'
                    },
                    {
                    date: '2016-05-01',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1519 弄'
                    },
                    {
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                    },
                    {
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                    },
                    {
                    date: '2016-05-01',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1519 弄'
                    },
                    {
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                    },
                    {
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                    }
                ],
                currentRow: null
            }
        },
        methods: {
            handleEdit() {

            }
        }
    }
</script>

<style lang="scss" scoped>

    #user {
        width: 100%;

        .title {
            @include mixin-flex(space-between, center);

            &-left {
                font-size: 16px;
                @include mixin-color(grey);

                & > span:last-of-type {
                    font-size: 12px;
                    margin-left: 11px;
                    @include mixin-color(dark);
                }
            }

            &-right {

                &-input {
                    width: 331px + 71px;
                }
            }
        }

        .edit {
            width: 60px;
            height: 21px;
            display: block;
            border: none;
            font-size: 14px;
            margin: 0px auto;
            @include mixin-color(white);
            @include mixin-bg-color(yellow);
        }

        .page {
            margin-top: 16px;
            @include mixin-flex(center, center);
        }
    }
</style>
