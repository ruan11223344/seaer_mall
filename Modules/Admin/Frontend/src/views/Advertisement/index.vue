<template>
    <el-main>
        <div>广告位列表</div>
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
                    property="date"
                    label="广告位名称"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="date"
                    label="宽度"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="name"
                    label="宽度"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    label="操作"
                    width="180px"
                    >
                    <template slot-scope="scope">
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
    </el-main>
</template>

<script>
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
    }
</script>

<style lang="scss" scoped>
    .edit {
        width: 60px;
        height: 21px;
        font-size: 14px;
        border: none;
        @include mixin-color(white);
        @include mixin-bg-color(yellow);
    }
</style>
