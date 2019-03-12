<template>
    <el-main>
        <v-list
            :total="total"
            :inputBool="true"
            @on-change-num="onChangeNum"
            @on-change-input="onChangeSearch"
            >
            <template slot="table">
                <el-table
                    ref="singleTable"
                    :data="productData"
                    style="width: 100%"
                    height="684px"
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
                        label="产品编号"
                        width="100px"
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
                productData: [],
                total: {
                    total: 0,
                    size: 18,
                    num: 1
                }
            }
        },
        methods: {
            handleEdit() {
                this.$router.push('/products/details')
            },
            // 分页
            onChangeNum(num) {
                this.$set(this.total, 'num', num)
                this.onGetProductList()
            },
            // 获取全部商品列表
            onGetProductList() {
                this.$GetRequest.getProductList(this.total.size, this.total.num)
                    .then(res => {
                        this.$set(this.total, 'total', res.total_size)
                        this.productData = res.data
                    }
                ).catch(err => {
                        return false
                    }
                )
            },
            // 搜索商品
            onChangeSearch() {

            }
        },
        mounted() {
            this.onGetProductList()
        },
        components: {
            'v-list': List
        }
    }
</script>

<style lang="scss" scoped>

    @mixin mixin-btn {
        height: 21px;
        font-size: 14px;
        border: none;
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
