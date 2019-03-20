<template>
    <div class="Send-main">
        <v-title title="Notice"></v-title>

        <div style="marginTop:20px;">
            <!-- <Table :height="formData.length > 8 ? 530 : ''" :columns="columns12" :data="formData" @on-selection-change="onChange"> -->
            <Table style="cursor: pointer;" :height="formData.length > 8 ? 530 : ''" :columns="columns12" :data="formData" @on-row-click="onClick">
                <!-- 内容 -->
                <template slot-scope="{ row }" slot="Content">
                    {{ row.article_title }}
                </template>
                <!-- 时间 -->
                <template slot-scope="{ row }" slot="time">
                        <time>{{ dayjs(row.publish_time ).format('MMM DD,YYYY HH:mm') }}</time>
                </template>
            </Table>

            <section style="marginTop:20px;">
                <template>
                    <Page :total="total.total" :page-size="total.size" style="textAlign: center" @on-change="onPages"/>
                </template>
            </section>
        </div>
        
    </div>
</template>

<script>
    import Title from "../components/Title"
    import dayjs from "dayjs"
    import getData from "@/utils/getData"

    export default {
        data () {
            return {
                total: {
                    size: 8,
                    total: 0,
                    num: 1
                },
                columns12: [
                    {
                        title: 'Title',
                        slot: 'Content',
                        align: 'center',
                        ellipsis: true,
                        sortable: true,
                    },
                    {
                        title: 'Date',
                        slot: 'time',
                        key: 'time',
                        align: 'center',
                        ellipsis: true,
                        sortable: true,
                    },
                ],
                formData: []
            }
        },
        methods: {
            dayjs: dayjs,
            onGetMallNotice: getData.onGetMallNotice,
            onPages(num) {
                this.$set(this.total, 'num', num)
                this.GetData()
            },
            GetData() {
                this.onGetMallNotice(this.total.num, this.total.size).then(res => {
                    this.$set(this.total, 'total', res.total_size)
                    this.formData = res.data
                })
            },
            onClick({ article_id }) {
                this.$router.push('/notice?article_id=' + article_id)
            }
        },
        mounted() {
            this.GetData()
        },
        components: {
            "v-title": Title,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .Send-main {
        .width(945px, 772px);
        .bg-color(white);
        padding: 21px 30px;
    }
</style>
