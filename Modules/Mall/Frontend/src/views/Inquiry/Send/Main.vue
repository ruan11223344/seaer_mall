<template>
    <div class="Send-main">
        <v-title title="Sent"></v-title>

        <section class="Send-main-screening">
            <div :class="bool == 0 ? 'Send-main-screening-text Send-main-screening-text-active' : 'Send-main-screening-text'" @click="filterAll(dataFrom.all), bool=0">All <span>{{ Info.All }}</span></div>
            <div class="Send-main-screening-hr"></div>
            <div :class="bool == 1 ? 'Send-main-screening-text Send-main-screening-text-active' : 'Send-main-screening-text'" @click="filterAll(dataFrom.read), bool=1">Read by the contact <span>{{ Info.Read }}</span></div>
            <div class="Send-main-screening-hr"></div>
            <div :class="bool == 2 ? 'Send-main-screening-text Send-main-screening-text-active' : 'Send-main-screening-text'" @click="filterAll(dataFrom.unread), bool=2">Not read by the contact <span>{{ Info.Unread }}</span></div>
        </section>

        <div class="Send-main-btn">
            <!-- 删除发件箱信息 -->
            <button @click="onDelete">Delete</button>
            <span>Total  {{ message_id.length }}</span>
        </div>

        <Table :height="data6.length > 8 ? 530 : ''" :columns="columns12" :data="data6" @on-selection-change="onSelect">
            <!-- 已读 -->
            <template slot-scope="{ row }" slot="isRead">
                <div>
                    <v-img width="23" :height="row.read ? '19' : '15'" :imgSrc="row.read ? require('@/assets/img/icon/yd.png') : require('@/assets/img/icon/wd.png') "></v-img>
                </div>
            </template>
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
                    <div  @click="onSign(row.message_id)">
                        <v-img width="11" height="22" :imgSrc="row.is_flag ? require('@/assets/img/icon/baoj.png') : require('@/assets/img/icon/wbj.png')" style="marginRight: 9px;cursor: pointer;"></v-img>
                    </div>
                    <router-link :to="'/inquiryList/read?' + 'message_id=' + row.message_id  + '&type=' + 'outbox'" tag="span" style="width:190px;overflow: hidden;textOverflow: ellipsis;whiteSpace: nowrap;cursor: pointer;">{{ (row.from_other_party_reply ? 'Re:' : '') + row.re }}</router-link>
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
                <Page :total="total.total" style="textAlign: center" @on-change="onPages"/>
            </template>
        </section>
        
    </div>
</template>

<script>
    import Title from "../components/Title"
    import Img from "@/components/Img"
    import dayjs from 'dayjs'

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
                    Read: 0
                },
                dataFrom: null,
                columns12: [
                    {
                        type: 'selection',
                        width: 60,
                        align: 'center',
                    },
                    {
                        title: ' ',
                        width: 60,
                        align: 'center',
                        slot: 'isRead'
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
                data6: [],
                message_id: []
            }
        },
        methods: {
            // 获取数据
            GetRequest() {
                this.$request({
                    url: '/message/outbox_message'
                }).then(({ code, data }) => {
                    if(code == 200) {
                        this.filterInbox(data)
                    }
                }).catch(err => {
                    // console.log(err)
                })
            },
            // 处理获取的收件箱数据
            filterInbox(data) {
                // this.SET_INBOX_FROM(data)
                this.dataFrom = data
                const Total = data.all.length + data.unread.length + data.read.length
                
                this.$set(this.Info, 'All', data.all.length)
                this.$set(this.Info, 'Unread', data.unread.length)
                this.$set(this.Info, 'Read', data.read.length)
                this.$set(this.Info, 'Total', Total)
                
                this.filterAll(data.all)
            },
            // 显示对应的数据
            filterAll(data) {
                this.data6 = []
                this.total.total = data.length
                const { num, size } = this.total
                const dataFrom = data.slice(num * size - 8, num * size)
                
                dataFrom.forEach((value, index) => {
                    this.data6.push({ 
                        is_reply: value.is_reply,
                        from_other_party_reply: value.from_other_party_reply,
                        message_id: value.message_id,
                        re: value.subject,
                        read: value.other_party_is_read,
                        is_flag: value.is_flag,
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
                        this.filterAll(this.dataFrom.all)
                        break;
                    case 1:
                        this.filterll(this.dataFrom.read)
                        break;
                    case 2:
                        this.filterAll(this.dataFrom.unread)
                        break;
                }
            },
            onSelect(value) { // 全选
                if(value.length > 0) {
                    let ids = []
                    // 获取删除消息的id值
                    value.forEach((value, index) => {
                        ids.push(value.message_id)
                    })
                    this.message_id = ids
                }else {
                    this.message_id = []
                    return false
                }
            },
            onDelete() {
                // 判断用户是否选中
                if(this.message_id.length > 0) {
                    let formData = new FormData();
                    for(let i = 0; i < this.message_id.length; i++) {
                        formData.append('messages_id_list[]', this.message_id[i])
                    }
                    formData.append('type', 'outbox')
                    formData.append('action', 'mark')

                    this.$request({
                        url: '/message/mark_delete_message',
                        method: 'post',
                        data: formData,
                        headers:{'Content-Type':'multipart/form-data'}
                    }).then(res => {
                        if(res.code == 200) {
                            this.$Message.info('Delete successful!')
                            this.GetRequest()
                            this.message_id = []
                        }else {
                            this.$Message.info('Delete failed!')
                            this.message_id = []
                        }
                    }).catch(err => {
                        // console.log(err)
                    })
                }else {
                    return false
                }
            },
            onSign(id) {
                // 标记收藏
                this.$request({
                    url: '/message/mark_flag_message',
                    method: 'post',
                    data: {
                        message_id: id,
                        type: 'outbox'
                    },
                }).then(res => {
                    if(res.code == 200) {
                        this.$Message.success('Marking success!')
                        this.GetRequest()
                    }else {
                        this.$Message.success('Marking failed!')
                    }
                }).catch(err => {
                    // console.log(err)
                })
            }
        },
        mounted() {
            this.GetRequest()
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
