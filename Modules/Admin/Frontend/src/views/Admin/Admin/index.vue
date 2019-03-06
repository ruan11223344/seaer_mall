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
                    :data="tableData"
                    style="width: 100%"
                    height="684px"
                    size="mini"
                    >

                    <el-table-column
                        align="center"
                        label="序号"
                        type="index"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="name"
                        label="登录名"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="name"
                        label="上次登录时间"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="name"
                        label="登录次数"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="name"
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
            <button class="Jurisdiction">+新增权限组</button>

            <template>
                <el-table
                    ref="singleTable"
                    :data="tableData"
                    style="width: 100%"
                    height="684px"
                    size="mini"
                    >

                    <el-table-column
                        align="center"
                        label="序号"
                        type="index"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="name"
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
            };
        },
        methods: {
            onAdd() {
                this.$router.push('/admin/add')
            },
            handleClick(tab, event) {
                console.log(tab, event);
            }
        }
    };
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
        
        @mixin mixin-btn {
            width: 60px;
            height: 21px;
            font-size: 14px;
            border: none;
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
