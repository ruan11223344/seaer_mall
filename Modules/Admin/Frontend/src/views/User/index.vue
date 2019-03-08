<template>
    <el-main>
        <v-list :total="total" @on-change-num="onChangeNum" :inputBool="true" empty-text="-">
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
                        property="num"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="register_time"
                        label="注册时间"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="af_id"
                        label="AF ID"
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
                        property="email"
                        label="会员邮箱"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="contact_full_name"
                        label="联系人姓名"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="sex"
                        label="性别"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="phone_num"
                        label="手机号"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="address"
                        label="地址"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        width="100px"
                        property="last_login"
                        label="最后登录时间"
                        show-overflow-tooltip
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
                this.onGetTableData()

            },
            onGetTableData() {
                this.$GetRequest.getUserList({ size: this.total.size, page: this.total.num })
                    .then(res => {
                        this.$set(this.total, 'total', res.total_size)
                        this.tableData = res.data
                    }
                )
            }
        },
        mounted() {
            this.onGetTableData()
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
