<template>
    <el-main>
        <v-list>
            <template slot="table">
                <el-table
                    ref="singleTable"
                    :data="tableData"
                    style="width: 100%"
                    height="684px"
                    size="mini"
                    >

                    <el-table-column
                        align="center"
                        property="date"
                        label="添加时间"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="date"
                        label="会员ID"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="name"
                        label="所留联系方式（电话、邮箱）"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="date"
                        label="内容"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="name"
                        label="用户类型"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="date"
                        label="状态"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        label="操作"
                        width="180px"
                        >
                        <template slot-scope="scope">
                            <button
                                class="del"
                                @click="handleEdit(scope.$index, scope.row)"
                                >
                                查看详情
                            </button>
                            <button
                                class="edit"
                                @click="handleEdit(scope.$index, scope.row)"
                                >
                                回复
                            </button>
                        </template>
                    </el-table-column>
                </el-table>
            </template>
        </v-list>
    </el-main>
</template>

<script>
    import List from "@/components/List"

    export default {
        data() {
            return {
                tableData: [
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
                    }
                ]
            }
        },
        methods: {
            handleEdit() {

            }
        },
        components: {
            'v-list': List
        }
    }
</script>

<style lang="scss" scoped>

    .del {
        width: 74px;
        @include mixin-btn;
        border: solid 1px #f0883a;
        @include mixin-color(yellow);
        @include mixin-bg-color(white);
    }

    .edit {
        width: 60px;
        margin-left: 12px;
        @include mixin-btn;
        @include mixin-color(white);
        @include mixin-bg-color(yellow);
    }
</style>
