<template>
    <div class="Send-main">
        <v-title title="Spam Report Inquiry"></v-title>

        <section class="Send-main-screening">
            <div class="Send-main-screening-text Send-main-screening-text-active">ALL <span>{{ dataFrom.length }}</span></div>
        </section>

        <div class="Send-main-btn">
            <button style="width: 112px;" @click="onCancel">Cancel  Spam</button>
            <span>Total {{thread_id.length }}</span>
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
                    <div  @click="onSign(row.participant_id, row.message_id, row.type)">
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
                dataFrom: [],
                total: {
                    size: 8,
                    total: 0,
                    num: 1
                },
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
                        re: 'Inquiry about...',
                        src: require('@/assets/img/china.png'),
                        time: 'Dec 28,2018  09:20',
                    }
                ],
                inboxData: [],
                outboxData: [],
                thread_id: []
            }
        },
        methods: {
            dayjs: dayjs,
            GetData() {
                this.$request({
                    url: '/message/spam_message',
                }).then(({ code, data }) => {
                    if(code == 200) {
                        this.dataFrom = data.all
                        this.filterAll(data.all)
                    }
                }).catch(err => {
                    return false
                })
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
            // 标记收藏
            onSign(id, message_id, type) {
                this.$request({
                    url: '/message/mark_flag_message',
                    method: 'post',
                    data: {
                        participant_id: id,
                        message_id: message_id,
                        type: type
                    },
                }).then(res => {
                    if(res.code == 200) {
                        this.$Message.info('Marking success!')
                        this.GetData()
                    }else {
                        this.$Message.info('Marking failed!')
                    }
                }).catch(err => {
                    return false
                })
            },
            // 分页
            onPages(index) {
                this.$set(this.total, 'num', index)
                this.filterAll(this.dataFrom)
            },
            onSelect(value) { // 全选
                if(value.length > 0) {
                    let ids = []
                    // 获取删除消息的id值
                    value.forEach((value, index) => {
                        ids.push(value.thread_id)
                    })
                    this.thread_id = ids
                }else {
                    this.thread_id = []
                    return false
                }
            },
            // 取消垃圾询盘标记
            onCancel() {
                let formData = new FormData()
                for (let index = 0; index < this.thread_id.length; index++) {
                    formData.append('thread_id_list[]', this.thread_id[index])
                }
                formData.append("action", "cancel")

                this.$request({
                    url: '/message/mark_spam_message',
                    method: 'post',
                    data: formData,
                    headers:{'Content-Type':'multipart/form-data'}
                }).then(({ code }) => {
                    if(code == 200) {
                        this.GetData()
                    }
                }).catch(err => {
                    return false
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
