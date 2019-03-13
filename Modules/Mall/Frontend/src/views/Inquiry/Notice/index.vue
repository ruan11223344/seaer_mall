<template>
    <div class="Send-main">
        <v-title title="Notice"></v-title>

        <div style="marginTop:20px;">
            <!-- <Table :height="formData.length > 8 ? 530 : ''" :columns="columns12" :data="formData" @on-selection-change="onChange"> -->
            <Table :height="formData.length > 8 ? 530 : ''" :columns="columns12" :data="formData">
                <!-- 内容 -->
                <template slot-scope="{ row }" slot="Content">
                        {{ row.product_name }}
                </template>
                <!-- 时间 -->
                <template slot-scope="{ row }" slot="time">
                        <!-- <time>{{ dayjs(row.updated_at ).format('MMM DD,YYYY HH:mm') }}</time> -->
                        <time>{{ row.time }}</time>
                </template>
            </Table>

            <section style="marginTop:20px;">
                <template>
                    <Page :total="total.total" :page-size="8" style="textAlign: center" @on-change="onPages"/>
                </template>
            </section>
        </div>
        
    </div>
</template>

<script>
    import Title from "../components/Title"
    import dayjs from "dayjs"

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
                        sortable: true
                    },
                    {
                        title: 'Date',
                        slot: 'time',
                        key: 'time',
                        align: 'center',
                        ellipsis: true,
                        sortable: true
                    },
                ],
                formData: [
                    {
                        product_name: 1,
                        time: 555
                    }
                ]
            }
        },
        methods: {
            dayjs: dayjs,
        },
        mounted() {
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
