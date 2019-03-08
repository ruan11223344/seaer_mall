<template>
    <el-main>
        <v-list :total="total">
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
            handleEdit() {

            },
            onGetBusinessList() {
                this.$GetRequest.getMerchantList(this.total.size, this.total.num)
                    .then(res => {
                        console.log(res)
                    }
                )
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
