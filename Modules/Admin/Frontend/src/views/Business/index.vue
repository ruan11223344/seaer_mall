<template>
    <div>
        <v-list>
            <template slot="table">
                <el-table
                    height="624px"
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
                        label="开店时间"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="name"
                        label="公司名称"
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
                        label="会员邮箱"
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
                        label="商品数量"
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
        </v-list>
    </div>
</template>

<script>
    import List from "@/components/List"

    export default {
        data() {
            return {
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
</style>
