<template>
    <div class="Send-main">
        <v-title title="Flag Inquiry"></v-title>

        <section class="Send-main-screening">
            <div :class="'Send-main-screening-text ' + (bool == 0 ? 'Send-main-screening-text-active' : '')" @click="bool=0, filterAll(inboxData)">Inbox <span>{{ inboxData.length }}</span></div>
            <div class="Send-main-screening-hr"></div>
            <div :class="'Send-main-screening-text ' + (bool == 1 ? 'Send-main-screening-text-active' : '')" @click="bool=1, filterAll(outboxData)">Sent <span>{{ outboxData.length }}</span></div>
        </section>

        <div class="Send-main-btn">
            <button @click="onDelete">Delete</button>
            <span>Total {{ bool == 0 ? message_id.length :  participant_id.length }}</span>
        </div>

        <Table :height="data6.length > 8 ? 530 : ''" :columns="columns12" :data="data6"  @on-selection-change="onSelect">
            <!-- 地区 -->
            <template slot-scope="{ row }" slot="Contact">
                <div class="Send-main-name">
                    <v-img width="27" height="19" :imgSrc="row.address == 'cn' ? require('@/assets/img/china.png') : require('@/assets/img/kenya.png')"></v-img>
                    <span>{{row.name}}</span>
                </div>
            </template>
            <!-- 内容 -->
            <template slot-scope="{ row }" slot="Content">
                <div class="Send-main-content">
                    <div  @click="onSign(row.participant_id, row.message_id)">
                        <v-img width="11" height="22" :imgSrc="row.is_flag ? require('@/assets/img/icon/baoj.png') : require('@/assets/img/icon/wbj.png')" style="marginRight: 9px;cursor: pointer;"></v-img>
                    </div>
                    <router-link :to="'/inquiryList/read?' + 'message_id=' + row.message_id + '&participant_id=' + row.participant_id + '&type=' + row.type" tag="span" style="width:190px;overflow: hidden;textOverflow: ellipsis;whiteSpace: nowrap;cursor: pointer;">{{ (row.from_other_party_reply ? 'Re:' : '') + row.re }}</router-link>
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
                <Page :total="total.total" :page-size="8" style="textAlign: center" @on-change="onPages"/>
            </template>
        </section>
        
    </div>
</template>

<script>
    import Title from "../components/Title"
    import Img from "@/components/Img"
    import dayjs from "dayjs"

    export default {
        data () {
            return {
                bool: 0,
                total: {
                    size: 8,
                    total: 0,
                    num: 1
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
                ],
                inboxData: [],
                outboxData: [],
                message_id: [],
                participant_id: []
            }
        },
        methods: {
            dayjs: dayjs,
            GetData() {
                this.$request({
                    url: '/message/flag_message',
                }).then(({ code, data }) => {
                    if(code == 200) {
                        this.filterData(data.all)
                    }
                }).catch(err => {
                    return false
                })
            },
            // 处理获取的数据
            filterData(data) {
                let inboxArr = []
                let outboxArr = []

                data.forEach(value => {
                    // 通过类型判断属于收件箱还是发件箱
                    if(value.type == 'outbox') {
                        outboxArr.push(value)
                    }else if(value.type == 'inbox') {
                        inboxArr.push(value)
                    }
                })

                this.inboxData = inboxArr
                this.outboxData = outboxArr
                this.filterAll(this.inboxData)
            },
            // 显示对应的数据
            filterAll(data) {
                this.data6 = []
                const { num, size } = this.total
                const dataFrom = data.slice(num * size - 8, num * size)
                this.total.total = data.length

                dataFrom.forEach((value, index) => {
                    this.data6.push({ 
                        type: value.type,
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
            },
            // 分页
            onPages(index) {
                this.$set(this.total, 'num', index)

                switch (this.bool) {
                    case 0:
                        this.filterAll(this.inboxData)
                        break;
                    case 1:
                        this.filterAll(this.outboxData)
                        break;
                }
            },
            // 标记收藏
            onSign(id, message_id) {
                this.$request({
                    url: '/message/mark_flag_message',
                    method: 'post',
                    data: {
                        participant_id: id,
                        message_id: message_id,
                        type: this.bool == 0 ? 'inbox' : 'outbox'
                    },
                }).then(res => {
                    if(res.code == 200) {
                        this.$Message.success('Marking success!')
                        this.GetData()
                        this.bool = 0
                    }else {
                        this.$Message.success('Marking failed!')
                    }
                }).catch(err => {
                    // console.log(err)
                    return false
                })
            },
            onSelect(value) { // 全选
                if(value.length > 0) {
                    let ids = []
                    let message = []
                    // 获取删除消息的id值
                    value.forEach((value, index) => {
                        ids.push(value.participant_id)
                        message.push(value.message_id)
                    })
                    this.participant_id = ids
                    this.message_id = message
                }else {
                    this.participant_id = []
                    this.message_id = []
                    return false
                }
            },
            onDelete() {
                // 判断用户是否选中
                let formData = new FormData();
                for(let i = 0; i < this.participant_id.length; i++) {
                    formData.append('participants_id_list[]', this.participant_id[i])
                }
                for(let i = 0; i < this.message_id.length; i++) {
                    formData.append('participants_id_list[]', this.message_id[i])
                }
                formData.append('type', this.bool == 0 ? 'inbox' : 'outbox')
                formData.append('action', 'mark')

                this.$request({
                    url: '/message/mark_delete_message',
                    method: 'post',
                    data: formData,
                    headers:{'Content-Type':'multipart/form-data'}
                }).then(res => {
                    if(res.code == 200) {
                        this.$Message.info('Delete successful!')
                        this.GetData()
                        this.participant_id = []
                        this.message_id = []
                    }else {
                        this.$Message.warning('Delete failed!')
                        this.participant_id = []
                        this.message_id = []
                    }
                }).catch(err => {
                    // console.log(err)
                })
               
            },
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
