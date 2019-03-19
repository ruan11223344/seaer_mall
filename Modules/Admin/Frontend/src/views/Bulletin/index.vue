<template>
    <el-main>
        <v-list
            :total="total"
            :inputBool="false"
            @on-change-num="onChangeNum"
            >
            <template slot="btn">
                <button class="btn" @click="$router.push('/article/publish?type=system_announcement')">
                    +新增
                </button>
            </template>
            <template slot="table">
                <el-table
                    v-loading="loading"
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
                        property="article_title"
                        label="标题"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        property="publish_time"
                        label="发布时间"
                        show-overflow-tooltip
                        >
                    </el-table-column>

                    <el-table-column
                        align="center"
                        label="操作"
                        width="185px"
                        >
                        <template slot-scope="scope">
                            <button
                                class="del"
                                @click="onDel(scope.row.article_id)"
                                >
                                删除
                            </button>
                            <button
                                class="edit"
                                @click="$router.push('/article/edit?article_id=' +  scope.row.article_id)"
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
                tableData: [],
                loading: false
            }
        },
        methods: {
            // 分页
            onChangeNum(num) {
                this.$set(this.total, 'num', num)
                this.onGetData()
            },
            onDel(article_id) {
                this.$PutRequest.putDelArticle(article_id)
                    .then(res => {
                        this.$message.success('操作成功')
                        this.onGetData()
                    })
                    .catch(err => {
                        this.$message.error(err.message)
                    })
            },
            onGetData() {
                this.loading = true
                this.$GetRequest.getSystemList(this.total.size, this.total.num)
                    .then(res => {
                        this.$set(this.total, 'total', res.total_size)
                        this.tableData = res.data
                        this.loading = false
                    })
                    .catch(err => {
                        this.loading = false
                        this.$message.error(err.message)
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
