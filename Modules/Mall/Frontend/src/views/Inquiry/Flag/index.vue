<template>
    <div class="Send-main">
        <v-title title="Flag Inquiry"></v-title>

        <section class="Send-main-screening">
            <div class="Send-main-screening-text Send-main-screening-text-active">Inbox <span>10</span></div>
            <div class="Send-main-screening-hr"></div>
            <div class="Send-main-screening-text">Sent <span>10</span></div>
        </section>

        <div class="Send-main-btn">
            <button>Delete</button>
            <span>Total 4</span>
        </div>

        <Table :height="data6.length > 8 ? 530 : ''" :columns="columns12" :data="data6">
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
                    <v-img width="11" height="22" :imgSrc="require('@/assets/img/icon/baoj.png')" style="marginRight: 9px;"></v-img>
                    <span>{{ 'Re:' + row.ask.re }}</span>
                    <!-- <span>{{ 'Dear:' + row.ask.Dear }}</span> -->
                </div>
            </template>
            <!-- 时间 -->
            <template slot-scope="{ row }" slot="time">
                <div>
                    <time>{{ row.time }}</time>
                </div>
            </template>
        </Table>
        
        <section style="marginTop:20px;">
            <template>
                <Page :total="100" style="textAlign: center"/>
            </template>
        </section>
        
    </div>
</template>

<script>
    import Title from "../components/Title"
    import Img from "@/components/Img"

    export default {
        data () {
            return {
                bool: 0,
                total: {
                    size: 8,
                    total: 100,
                    num: 1
                },
                Info: {
                    Total: 0,
                    All: 0,
                    Unread: 0,
                    Reply: 0
                },
                dataFrom: null,
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
                        sortable: true
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
                        time: 'Dec 28,2018  09:21',
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
                        time: 'Dec 28,2018  09:25',
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
        methods: {
            GetData() {
                this.$request({
                    url: '/message/flag_message',
                }).then(res => {
                    console.log(res);
                }).catch(err => {
                    return false
                })
            },
            // 处理获取的收件箱数据
            filterInbox(data) {
                this.SET_INBOX_FROM(data)
                this.dataFrom = data
                const Total = data.all.length + data.unread.length + data.pending_for_reply.length
                this.$set(this.Info, 'All', data.all.length)
                this.$set(this.Info, 'Unread', data.unread.length)
                this.$set(this.Info, 'Reply', data.pending_for_reply.length)
                this.$set(this.Info, 'Total', Total)
                this.filterAll(data.all)
            },
            // 显示对应的数据
            filterAll(data) {
                this.data6 = []
                const { num, size } = this.total
                const dataFrom = data.slice(num * size - 8, num * size)
                this.total.total = data.length
                
                dataFrom.forEach((value, index) => {
                    this.data6.push({
                        is_reply: value.is_reply,
                        from_other_party_reply: value.from_other_party_reply,
                        message_id: value.message_id,
                        thread_id: value.thread_id,
                        participant_id: value.participant_id,
                        is_flag: value.is_flag,
                        re: value.subject,
                        read: value.is_read,
                        name: value.send_by_name,
                        address: value.send_country,
                        time: dayjs(value.send_at.date).format('MMM DD,YYYY HH:mm')
                    })
                })
            }
        },
        mounted() {
            this.GetData()
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
        .width(945px, 772px);
        .bg-color(white);
        padding: 21px 30px;

        &-screening {
            width: 886px;
            height: 47px;
            background-color: #f5f5f9;
            margin-top: 19px;
            .flex(flex-start, center);
            padding-left: 27px;

            &-text {
                .lineHeight(47px);
                font-size: 14px;
                color: #666666;

                & > span {
                    color: #d72b2b;
                }
                cursor: pointer;
            }
            &-text-active {
                border-bottom: 2px solid #f0883a;
            }

            &-hr {
                width: 1px;
                height: 11px;
                background-color: #cccccc;
                margin: 0px 18px;
            }
        }

        &-btn {
            .flex();
            margin-top: 15px;
            margin-bottom: 12px;
            & > button {
                .color(white);
                .lineHeight(25px);
                .bg-color(Orange);
                width: 66px;
                font-size: 14px;
                border: none;
                margin-right: 10px;
            }
            & > span {
                .lineHeight(25px);
                font-size: 14px;
                color: #f0883a;
                display: inline-block;
                cursor: pointer;
            }
        }

        &-name {
            .flex(center);

            & > span {
                .textHidden();
                text-align: left;
                max-width: 192px;
                margin-left: 7px;
                font-size: 14px;
                color: #666666;
            }
        }

        &-content {
            .flex();
            text-align: left;
        }   
    }
</style>
