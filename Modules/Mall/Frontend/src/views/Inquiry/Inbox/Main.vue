<template>
    <div class="Send-main">
        <v-title title="Inbox"></v-title>

        <section class="Inbox-state">
            <div class="state-active">All 10</div>
            <div>Unread 10</div>
            <div>Not yet replied 0</div>
        </section>

        <div class="Inbox-screening">
            <div class="Inbox-btns">
                <button>Mark</button>
                <button>Delete</button>
                <button>Spam</button>
            </div>

            <section class="Inbox-search">
                <input />
                <button>search</button>
            </section>
        </div>

        <Table :height="data6.length > 7 ? 472 : ''" :columns="columns12" :data="data6">
            <template slot-scope="{ row }" slot="read">
                <div :data-row="row">
                    <v-img width="21" height="15" :imgSrc="require('@/assets/img/home/weidu.png')"></v-img>
                    <!-- <v-img width="21" height="15" :imgSrc="require('@/assets/img/home/yidu.png')"></v-img> -->
                </div>
            </template>
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
                        align: 'left',
                    },
                    {
                        title: ' ',
                        slot: 'read',
                        width: 60,
                    },
                    {
                        title: 'Contact',
                        slot: 'Contact',
                        align: 'left',
                    },
                    {
                        title: 'Content',
                        slot: 'Content',
                        align: 'left'

                    },
                    {
                        title: 'Sent Time',
                        slot: 'time',
                        key: 'time',
                        align: 'left',
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

    .Inbox-state {
        .flex();
        .width(886px, 47px);
        .bg-color(light);
        line-height: 47px;
        margin-top: 26px;
        margin-bottom: 17px;
        padding-left: 12px;
        
        & > div {
            position: relative;
            margin: 0px 15px;
            cursor: pointer;
        }

        & > .state-active {
            border-bottom: 2px solid#f0883a;;
        }

        & > div::before {
            .bg-color(whiteDark);
            content: '';
            width: 1px;
            height: 11px;
            position: absolute;
            top: 47px / 2 - 11px / 2;
            right: -15px;
        }
    }

    .Inbox-screening {
        .flex(space-between, center);
        margin-bottom: 18px;
    }

    .Inbox-search {
        .flex();
        height: 39px;

        & > input:first-child {
            .width(289px, 39px);
            .color(blackDark);
            font-size: 14px;
            margin-right: 21px;
            padding-left: 10px;
            border: solid 1px #dddddd;
        }

        & > button:last-child {
            .width(80px, 39px);
            .color(white);
            .bg-color(orange2);
            font-size: 16px;
            border: none;
        }
    }

    .Inbox-btns {
        height: 25px;

        & > button {
            .width(66px, 25px);
            .color(white);
            .bg-color(Orange);
            border: none;
            font-size: 14px;
            margin-right: 10px;
        }
    }
</style>
