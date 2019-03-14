<template>
    <el-main>
        <v-list
            :total="total"
            :inputBool="false"
            @on-change-num="onChangeNum"
            >
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
                        property="add_time"
                        label="添加时间"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="member_id"
                        label="会员ID"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="contact_way"
                        label="所留联系方式（电话、邮箱）"
                        width="200px"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="user_message"
                        label="内容"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="user_type_str"
                        label="用户类型"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="status_str"
                        label="状态"
                        show-overflow-tooltip
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
                                @click="onDetails(scope.row)"
                                >
                                查看详情
                            </button>
                            <button
                                v-if="!scope.row.is_spam"
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
                tableData: [],
                total: {
                    total: 0,
                    size: 18,
                    num: 1
                }
            }
        },
        methods: {
            // 分页
            onChangeNum(num) {
                this.$set(this.total, 'num', num)
                this.onGetData()
            },
            handleEdit() {
                // this.$router.push('/opinion/details')
            },
            onDetails(value) {
                const obj = JSON.stringify(value)
                this.$router.push('/opinion/details?obj=' + obj)
            },
            // 获取数据
            onGetData() {
                this.$GetRequest.getFeedbackList(this.total.size, this.total.num)
                    .then(res => {
                        this.$set(this.total, 'total', res.total_size)
                        this.tableData = res.data
                    })
            }
        },
        created() {
            this.onGetData()
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
