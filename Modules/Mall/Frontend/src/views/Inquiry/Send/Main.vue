<template>
    <div class="Send-main">
        <v-title title="Send"></v-title>

        <button class="Send-main-btn">Delete</button>

        <Table border :height="data6.length > 8 ? 530 : ''" :columns="columns12" :data="data6">
            <!-- 地区 -->
            <template slot-scope="{ row }" slot="Contact">
                <div class="Send-main-name">
                    <v-img width="27" height="19" :imgSrc="row.src"></v-img>
                    <span>{{row.name}}</span>
                </div>
            </template>
            <!-- 内容 -->
            <template slot-scope="{ row }" slot="Content">
                <div class="Send-main-content">
                    <span>{{ 'Re:' + row.ask.re }}</span>
                    <span>{{ 'Dear:' + row.ask.Dear }}</span>
                </div>
            </template>
            <!-- 时间 -->
            <template slot-scope="{ row }" slot="time">
                <div>
                    <time>{{ row.time }}</time>
                </div>
            </template>
        </Table>
    </div>
</template>

<script>
    import Title from "../components/Title"
    import Img from "@/components/Img"

    export default {
        data () {
            return {
                columns12: [
                    {
                        type: 'selection',
                        width: 60,
                        align: 'center',
                    },
                    {
                        title: 'Contact',
                        slot: 'Contact',
                        align: 'center',
                    },
                    {
                        title: 'Content',
                        slot: 'Content',
                        align: 'center'

                    },
                    {
                        title: 'Sent Time',
                        slot: 'time',
                        key: 'time',
                        align: 'center',
                    },
                    
                ],
                data6: [
                    {
                        name: 'John Brown',
                        ask: {
                            re: 'Inquiry about...',
                            Dear: 'Mary...'
                        },
                        src: require('@/assets/img/china.png'),
                        time: 'Dec 28,2018  09:20',
                    },
                    {
                        name: 'Jim Green',
                        src: require('@/assets/img/china.png'),
                        ask: {
                            re: 'Inquiry about...',
                            Dear: 'Mary...'
                        },
                        time: 'Dec 28,2018  09:20',
                    },
                    {
                        name: 'Jim Green',
                        src: require('@/assets/img/china.png'),
                        ask: {
                            re: 'Inquiry about...',
                            Dear: 'Mary...'
                        },
                        time: 'Dec 28,2018  09:20',
                    },
                    {
                        name: 'Jim Green',
                        src: require('@/assets/img/china.png'),
                        ask: {
                            re: 'Inquiry about...',
                            Dear: 'Mary...'
                        },
                        time: 'Dec 28,2018  09:20',
                    },
                    {
                        name: 'Jim Green',
                        src: require('@/assets/img/china.png'),
                        ask: {
                            re: 'Inquiry about...',
                            Dear: 'Mary...'
                        },
                        time: 'Dec 28,2018  09:20',
                    },
                    {
                        name: 'Jim Green',
                        src: require('@/assets/img/china.png'),
                        ask: {
                            re: 'Inquiry about...',
                            Dear: 'Mary...'
                        },
                        time: 'Dec 28,2018  09:20',
                    },
                    {
                        name: 'Jim Green',
                        src: require('@/assets/img/china.png'),
                        ask: {
                            re: 'Inquiry about...',
                            Dear: 'Mary...'
                        },
                        time: 'Dec 28,2018  09:20',
                    },
                    {
                        name: 'Jim Green',
                        src: require('@/assets/img/china.png'),
                        ask: {
                            re: 'Inquiry about...',
                            Dear: 'Mary...'
                        },
                        time: 'Dec 28,2018  09:20',
                    },
                    {
                        name: 'Jim Green',
                        src: require('@/assets/img/china.png'),
                        ask: {
                            re: 'Inquiry about...',
                            Dear: 'Mary...'
                        },
                        time: 'Dec 28,2018  09:20',
                    },
                ]
            }
        },
        components: {
            "v-title": Title,
            "v-img": Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .Send-main {
        .width(945px, 700px);
        .bg-color(white);
        padding: 24px 30px;

        &-btn {
            .color(white);
            .lineHeight(25px);
            .bg-color(Orange);
            width: 66px;
            font-size: 14px;
            letter-spacing: 0px;
            border: none;
            margin-top: 26px;
            margin-bottom: 18px;
            display: block;
        }

        &-name {
            .flex();

            & > span {
                .textHidden();
                text-align: left;
                width: 192px;
                margin-left: 7px;
                font-size: 14px;
                color: #666666;
            }
        }

        &-content {
            text-align: left;

            & > span {
                display: block;
                width: 230px;
            }
        }   
    }
</style>
