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
                        width="260px"
                        >
                        <template slot-scope="scope">
                            <button
                                class="del"
                                @click="onDetails(scope.row)"
                                >
                                查看详情
                            </button>
                            <template>
                                <button
                                    v-if="!scope.row.is_spam"
                                    style="width: 75px;"
                                    class="edit"
                                    @click="onSpam(scope.row)"
                                    >
                                    垃圾邮件
                                </button>
                                <button
                                    v-if="!scope.row.is_process"
                                    class="edit"
                                    @click="handleEdit(scope.row.feedback_id)"
                                    >
                                    处理
                                </button>
                            </template>
                        </template>
                    </el-table-column>
                </el-table>
            </template>
        </v-list>

        <v-modality
            v-show="modality"
            @on-hide="onHide"
            title="反馈"
            >
            <section class="box" slot="main">
                <el-row :gutter="20" class="box-block">
                    <el-col :span="24">
                        <el-input
                            type="textarea"
                            resize="none"
                            :autosize="{ minRows: 11, maxRows: 11}"
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
                modality: false,
                tableData: [],
                total: {
                    total: 0,
                    size: 18,
                    num: 1
                },
                reject_message: '',
                feedback_id: null
            }
        },
        methods: {
            // 隐藏模态框
            onHide() {
                this.modality = false
            },
            // 分页
            onChangeNum(num) {
                this.$set(this.total, 'num', num)
                this.onGetData()
            },
            // 公共方法
            Handle(data) {
                this.$PutRequest.putProcess(data)
                    .then(res => {
                        this.$message.success()
                        this.onGetData()
                    })
                    .catch(err => {
                        this.$message.error(err.message)
                    })

                this.modality = false
                this.feedback_id = null
                this.reject_message = ''
            },
            // 垃圾邮件
            onSpam({ feedback_id }) {
                this.Handle({ feedback_id, is_spam: true, })
            },
            // 处理
            onSub() {
                this.Handle({
                    feedback_id: this.feedback_id,
                    is_spam: false,
                    admin_message: this.reject_message
                })
            },
            handleEdit(feedback_id) {
                this.modality = true
                this.feedback_id = feedback_id
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
        padding: 0px 30px;
        box-sizing: border-box;
        @include mixin-bg-color(white);

        &-block:first-child {
            height: auto;
            margin-top: 22px;
            margin-bottom: 26px;
        }

        &-btn {
            width: 107px;
            margin: 0px auto;
            margin-top: 33px;
            display: block;
        }
    }
</style>
