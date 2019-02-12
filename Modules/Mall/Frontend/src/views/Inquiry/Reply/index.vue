<template>
    <div class="reply">
        <section class="reply-btn">
            <button type="button" @click="onSend">Send</button>
            <button type="button" @click="$router.go(-2)">Close</button>
        </section>

        <section class="reply-card">
            <div class="reply-card-title">
                <label for="">To:</label>
                <span>{{ infoData.send_to_name }}</span>
            </div>
            <div class="reply-card-subject">
                <label for="">Subject:</label>
                <span>{{ infoData.subject }}</span>
            </div>
            <div class="reply-card-info">
                <!-- 展示图片 -->
                <v-img width="64" height="64" imgSrc=""></v-img>
                <div class="reply-card-info-text">
                    <span>Purchase Quantity:{{ infoData.purchase_quantity }}</span>
                    <span v-if="infoData.extra_request">Extra Request:{{ infoData.extra_request }}</span>
                </div>
            </div>
        </section>

        <section class="reply-input">
            <!-- 询问内容 -->
            <textarea v-model="text"></textarea>
        </section>
        
        <template v-if="infoData.quote_message">
            <Collapse simple class="reply-history" :value="name">
                <Panel name="1" :hide-arrow="true">
                    <div class="reply-history-title">
                        <span>Quote</span>
                        <Icon :type="name[0] == '1' ? 'ios-arrow-down' : 'ios-arrow-forward'" class="reply-history-title-icon"/>
                    </div>
                    <!-- 历史信息 -->
                    <section slot="content" class="reply-history-content">
                        <dl class="reply-history-content-item">
                            <dd class="reply-history-content-item-list">
                                <label for="">From: </label>
                                <span>{{ infoData.quote_message[0].send_by_name }}</span>
                            </dd>
                            <dd class="reply-history-content-item-list">
                                <label for="">To: </label>
                                <span>{{ infoData.quote_message[0].send_to_name }}</span>
                            </dd>
                            <dd class="reply-history-content-item-list">
                                <label for="">Sent: </label>
                                <span>{{ dayjs(infoData.quote_message[0].send_at.date).format('MMM DD,YYYY HH:mm') }}</span>
                            </dd>
                            <dd class="reply-history-content-item-list">
                                <label for="">Subject: </label>
                                <span>{{ infoData.quote_message[0].subject }}</span>
                            </dd>
                            <dd class="reply-history-content-item-list reply-history-content-item-title">
                                <label for="">{{ infoData.quote_message[0].content }}</label>
                            </dd>
                        </dl>
                    </section>
                </Panel>
            </Collapse>
        </template>
    </div>
</template>

<script>
    import Img from '@/components/Img'
    import dayjs from 'dayjs'

    export default {
        data() {
            return {
                name: [],
                infoData: {
                    send_at: {
                        date: '2019-01-25 15:04:11.000000'
                    },
                    quote_message: [
                        {
                            "subject": "",
                            "content": "",
                            "send_at": {
                                "date": "2019-01-24 13:48:37.000000",
                            },
                            "send_by_name": "",
                            "send_to_name": "",
                        }
                    ]
                },
                infoQuery: {},
                text: ''
            }
        },
        methods: {
            dayjs: dayjs,
            // 获取数据
            GetData(type) {

                let datas = { type }
                
                if(type == 'outbox') {
                    datas.message_id = this.$route.query.message_id
                }else if(type == 'inbox') {
                    datas.message_id = this.$route.query.message_id
                    datas.participant_id = this.$route.query.participant_id
                }

                this.$request({
                    url: '/message/message_info',
                    params: datas
                }).then(({ code, data }) => {
                    if(code == 200) {
                        this.infoData = data[0]
                        this.infoQuery = datas
                        console.log(this.infoData)
                    }else {
                        this.$router.push('/inquiryList/send')
                    }
                }).catch(err => {
                    return false
                })
            },
            // 发送
            onSend() {
                // 参数:"message_id",值:"32"   //必填  要回复的消息id
                // 参数:"attachment_list",值:"多文件上传"   //必填   附件上传接口 以file格式上传 表单加 [] 否则不予通过 ,就算一个文件也是已数组形式传输 
                // 参数:"quote_message_id",值:"35"   //引用消息的id   非必填
                // 参数:"content",值:"非洲香蕉大 真好吃！！"  //必填 发送的主体内容
                let formData = new FormData()

                formData.append('message_id', this.infoQuery.message_id)
                formData.append('attachment_list', '')
                formData.append('quote_message_id', this.infoData.quote_message ? this.infoData.quote_message[0].message_id : '')
                formData.append('content', this.text)

                this.$request({
                    url: '/message/reply_message',
                    method: 'post',
                    data: formData
                }).then(res => {
                    if(res.code == 200) {
                        this.$Message.success('Send successfully!');
                    }else {
                        this.$Message.warning('fail in send!');
                    }
                }).catch(err => {
                    return false
                })
            }
        },
        mounted() {
            this.GetData(this.$route.query.type)
        },
        components: {
            'v-img': Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .reply {
        width: 945px;
        align-self: flex-start;

        &-btn {
            .flex(flex-start, center);
            height: 54px;
            background-color: #ffffff;
            // margin-bottom: 2px;
            border-bottom: 2px solid #f5f5f9;

            & > button {
                border: none;
                width: 66px;
                height: 25px;
                background-color: #f0883a;
                font-size: 14px;
                color: #ffffff;
                margin-left: 16px;
            }
            
            & > button:last-of-type {
                margin-left: 12px;
                color: #f0883a;
                background-color: #fff8f3;
	            border: solid 1px #f0883a;
            }
        }

        &-card {
            padding-top: 23px;
            padding-left: 16px;
            padding-bottom: 15px;
            background-color: #e9e9ed;

            &-title, &-subject {

                & > label {
                    font-size: 14px;
                    line-height: 1;
                    color: #333333;
                }

                & > span {
                    font-size: 14px;
                    line-height: 1;
                    color: #666666;
                    margin-left: 11px;
                }
            }

            &-subject {
                margin-top: 23px;
            }

            &-info {
                .flex();
                margin-top: 15px;

                &-text {
                    .flex(center, flex-start, column);
                    margin-left: 18px;

                    & > span {
                        font-size: 14px;
                        line-height: 1;
                        color: #666666;
                    }

                    & > span:first-child {
                        margin-bottom: 11px;
                    }
                }
            }


        }

        &-input {
            height: 173px;
            background-color: #ffffff;
            border-bottom: 2px solid #f5f5f9;
            
            & > textarea {
                width: 100%;
                height: 100%;
                resize: none;
                border: none;
                padding: 10px;
            }
        }
        
        &-history {
            height: 35px;
            background-color: #e9e9ed;
            border: none;
            
            &-title {
                .flex(flex-start, center);
                height: 35px;
                line-height: 35px;
                font-size: 14px;
                color: #333333;
                cursor: pointer;
                
            }

            &-content {
                height: 160px;
                padding: 15px 20px;

                &-item {
                    width: 100%;
                    height: 100%;
                    padding-left: 12px;
                    border-left: 1px solid #dddddd;

                    &-list {
                        font-size: 14px;
                        line-height: 1;
                        color: #333333;
                        margin-bottom: 12px;

                        & > span {
                            font-size: 14px;
                            color: #666666;
                        }
                    }

                    &-title {
                        margin-top: 19px;
                    }

                }
            }
        }
        
    }
</style>
