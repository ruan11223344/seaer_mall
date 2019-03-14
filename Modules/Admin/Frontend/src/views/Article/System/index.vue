<template>
    <el-main>
        <v-list>
            <template slot="btn">
                <button class="btn" @click="$router.push('/article/edit')">
                    +新增
                </button>
            </template>
            <template slot="table">
                <el-table
                    ref="singleTable"
                    :data="tableData"
                    style="width: 100%"
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
                        label="标题"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="name"
                        label="发布时间"
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
        </v-list>
    </el-main>
</template>

<script>
    import List from "@/components/List"

    export default {
        data() {
            return {
                tableData: []
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

    .btn {
        font-size: 16px;
        width: 71px;
        height: 25px;
        border: none;
        @include mixin-color(white);
        @include mixin-bg-color(yellow);
    }

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
