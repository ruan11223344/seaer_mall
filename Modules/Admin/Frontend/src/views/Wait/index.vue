<template>
    <el-main>
        <v-list
            :total="total"
            :inputBool="true"
            @on-change-num="onChangeNum"
            >
            <template slot="table">
                <el-table
                    ref="singleTable"
                    :data="waitData"
                    style="width: 100%"
                    size="mini"
                    >

                    <el-table-column
                        align="center"
                        label="序号"
                        width="100px"
                        property="num"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="product_id"
                        width="100px"
                        label="产品编号"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="product_name"
                        label="商品名称"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="product_price"
                        label="商品价格（KSh）"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="company_name"
                        label="店铺商家"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="company_detail_address"
                        label="地址"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="product_status_str"
                        label="商品状态"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        label="操作"
                        width="183px"
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
                                下架
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
                waitData: [],
                total: {
                    total: 0,
                    size: 18,
                    num: 1
                }
            }
        },
        methods: {
            handleEdit() {

            },
            // 分页
            onChangeNum(num) {
                this.$set(this.total, 'num', num)
                this.onGetWaitList()
            },
            // 获取待审核商品
            onGetWaitList() {
                this.$GetRequest.getProductAuditList(this.total.size, this.total.num)
                    .then(res => {
                        this.$set(this.total, 'total', res.total_size)
                        this.waitData = res.data
                    }
                ).catch(err => {
                    return false
                })
            }
        },
        mounted() {
            this.onGetWaitList()
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
