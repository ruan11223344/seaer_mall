<template>
    <el-main>
        <v-list
            :total="total"
            :inputBool="false"
            @on-change-num="onChangeNum"
            >
            <template slot="btn">
                <button class="btn" @click="$router.push('/article/publish?type=merchants_register_agreement')">
                    +新增
                </button>
            </template>
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
                        label="序号"
                        property="num"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="article_title"
                        label="标题"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="article_type"
                        label="协议类型"
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="publish_time"
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
                total: {
                    total: 0,
                    size: 18,
                    num: 1
                },
                tableData: []
            }
        },
        methods: {
            // 分页
            onChangeNum(num) {
                this.$set(this.total, 'num', num)
                this.onGetData()
            },
            handleEdit() {

            },
            onGetData() {
                this.$GetRequest.getAgreementsList(this.total.size, this.total.num)
                    .then(res => {
                        this.$set(this.total, 'total', res.total_size)
                        this.filtersData(res.data)
                    })
            },
            filtersData(data) {
                const arr = []
                data.forEach(v => {
                    arr.push({
                        article_id: v.article_id,
                        article_title: v.article_title,
                        article_type: v.article_type == "buyers_register_agreement" ? '买家注册协议' : '商户注册协议',
                        num: v.num,
                        publish_time: v.publish_time
                    })
                })

                this.tableData = arr
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

    .btn {
        font-size: 16px;
        width: 71px;
        height: 25px;
        border: none;
        @include mixin-color(white);
        @include mixin-bg-color(yellow);
    }

    @mixin mixin-btn {
        height: 21px;
        font-size: 14px;
        border: none;
    }

    .edit {
        width: 60px;
        @include mixin-btn;
        @include mixin-color(white);
        @include mixin-bg-color(yellow);
    }
</style>
