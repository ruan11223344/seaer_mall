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
                    v-loading="loading"
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
                                @click="onDetails(scope.row.product_id)"
                                >
                                查看详情
                            </button>
                            <button
                                class="edit"
                                @click="onWait(scope.row)"
                                >
                                审核
                            </button>
                        </template>
                    </el-table-column>
                </el-table>
            </template>
        </v-list>

        <v-modality
            v-show="modality"
            @on-hide="onHide"
            title="审核"
            >
            <section class="box" slot="main">
                <el-row :gutter="20" class="box-block">
                    <el-col :span="4">
                        <div class="box-title">审核</div>
                    </el-col>
                    <el-col :span="20">
                        <el-radio-group v-model="action" class="box-radio">
                            <el-radio label="allow">通过</el-radio>
                            <el-radio label="reject">不通过</el-radio>
                        </el-radio-group>
                    </el-col>
                </el-row>
                <el-row :gutter="20" class="box-block">
                    <el-col :span="4">
                        <div class="box-title" style="lineHeight: 1;">不通过原因</div>
                    </el-col>
                    <el-col :span="20">
                        <el-input
                            :disabled="action == 'allow'"
                            type="textarea"
                            resize="none"
                            :autosize="{ minRows: 8, maxRows: 8}"
                            v-model="reject_message">
                        </el-input>
                    </el-col>
                </el-row>

                <el-button type="primary" class="box-btn" @click="onSub">确定</el-button>
            </section>
        </v-modality>
    </el-main>
</template>

<script>
    import List from "@/components/List"
    import Modality from "@/components/Modality"

    export default {
        data() {
            return {
                loading: false,
                modality: false,
                waitData: [],
                total: {
                    total: 0,
                    size: 18,
                    num: 1
                },
                action: 'reject',
                reject_message: '',
                product_id: null
            }
        },
        methods: {
            // 点击提交
            onSub() {
                if(this.action == 'reject' && this.reject_message == '') {
                    this.$message({
                        showClose: true,
                        message: '请填写不通过原因',
                        type: 'warning'
                    })

                    return false
                }

                this.$PutRequest.putProductAudit({
                        product_id: this.product_id,
                        action: this.action,
                        reject_message: this.reject_message
                    })
                        .then(res => {
                            this.$message({
                                showClose: true,
                                message: '操作成功',
                                type: 'success'
                            })

                            this.reject_message = ''
                            this.product_id = null
                            this.modality = false

                            this.onGetWaitList()
                        })
                        .catch(err => {
                            this.$message({
                                showClose: true,
                                message: err.message,
                                type: 'error'
                            })
                            this.reject_message = ''
                            this.product_id = null
                            this.modality = false

                        })
            },
            // 隐藏模态框
            onHide() {
                this.modality = false
                this.product_id = null
            },
            // 审核
            onWait({ product_id }) {
                this.modality = true
                this.product_id = product_id
            },
            // 查看详情
            onDetails(product_id) {
                this.$router.push('/products/details?product_id=' + product_id)
            },
            // 分页
            onChangeNum(num) {
                this.$set(this.total, 'num', num)
                this.onGetWaitList()
            },
            // 获取待审核商品
            onGetWaitList() {
                this.loading = true
                this.$GetRequest.getProductAuditList(this.total.size, this.total.num)
                    .then(res => {
                        this.$set(this.total, 'total', res.total_size)
                        this.waitData = res.data
                        this.loading = false
                    }
                ).catch(err => {
                    this.loading = false
                    return false
                })
            },
            // 搜索商品
            onChangeSearch(key) {
                if(key == '') {
                    this.onGetWaitList()
                }else {
                    this.loading = true
                    this.$GetRequest.getSearchProduct(this.total.size, this.total.num, key, '待审核')
                        .then(res => {
                            this.$set(this.total, 'total', res.total_size)
                            this.waitData = res.data
                            this.loading = false
                        }
                    )
                }
            }
        },
        mounted() {
            this.onGetWaitList()
        },
        components: {
            'v-list': List,
            'v-modality': Modality
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

    .box {
        width: 722px;
        height: 433px - 70px;
        padding-left: 10px;
        padding-right: 30px;
        box-sizing: border-box;
        @include mixin-bg-color(white);

        &-block:first-child {
            height: 40px;
            margin-top: 22px;
            margin-bottom: 26px;
        }

        &-title {
            height: 40px;
            font-size: 16px;
            line-height: 40px;
            text-align: right;
            @include mixin-color(grey);
        }

        &-radio {
            height: 40px;
            box-sizing: border-box;
            padding-top: 5px;
            @include mixin-flex(flex-start, center);
        }

        &-btn {
            width: 107px;
            margin: 0px auto;
            margin-top: 33px;
            display: block;
        }
    }
</style>
