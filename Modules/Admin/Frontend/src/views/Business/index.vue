<template>
    <el-main>
        <v-list
            :total="total"
            @on-change-num="onChangeNum"
            @on-change-input="onChangeSearch"
            :inputBool="true"
            >
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
                        property="open_shop_time"
                        label="开店时间"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="company_name"
                        label="公司名称"
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
                        property="email"
                        label="会员邮箱"
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
                        property="product_num"
                        label="商品数量"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
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
                                :class="scope.row.allow_inquiry ? 'edit' : 'edit2'"
                                @click="handleEdit(scope.row.user_id, scope.$index, scope.row.allow_inquiry)"
                                >
                                {{scope.row.allow_inquiry ? '允许' : '禁止'}}
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
                this.onGetBusinessList()
            },
            // 操作
            handleEdit(user_id, index, allow_inquiry) {
                this.$PutRequest.putInquiryJurisdiction(user_id)
                    .then(res => {
                        this.$set(this.tableData[index], 'allow_inquiry', !allow_inquiry)
                        this.$message({
                            message: '修改成功',
                            type: 'success'
                        });
                    }
                ).catch(err => {
                        this.$message({
                            message: res.message,
                            type: 'error'
                        });
                    }
                )
            },
            onGetBusinessList() {
                this.$GetRequest.getMerchantList(this.total.size, this.total.num)
                    .then(res => {
                        this.$set(this.total, 'total', res.total_size)
                        this.tableData = res.data
                    }
                )
            },
            onChangeSearch(key) {
                if(key == '') {
                    this.onGetBusinessList()
                }else {
                    this.$GetRequest.getSearchUserList(this.total.size, this.total.num, key)
                        .then(res => {
                            this.$set(this.total, 'total', res.total_size)
                            this.tableData = res.data
                        }
                    )
                }
                
            }
        },
        mounted() {
            this.onGetBusinessList()
        },
        components: {
            'v-list': List
        }
    }
</script>

<style lang="scss" scoped>
    @mixin mixin-edit {
        width: 60px;
        height: 21px;
        display: block;
        font-size: 14px;
        margin: 0px auto;
        border: none;
    }

    .edit {
        @include mixin-edit;
        @include mixin-color(white);
        @include mixin-bg-color(yellow);
    }

    .edit2 {
        @include mixin-edit;
        border: solid 1px #f0883a;
        @include mixin-color(yellow);
        @include mixin-bg-color(white);
    }
</style>
