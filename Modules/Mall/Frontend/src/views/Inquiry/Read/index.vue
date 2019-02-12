<template>
    <div class="read-main">
        <section class="read-main-btn">
            <button @click="$router.go(-1)">Return</button>
            <button @click="$router.push('/inquiryList/reply?' + 'message_id=' + infoQuery.message_id + '&type=' + infoQuery.type)" class="read-main-btn-active">Reply</button>
            <button @click="onDelete">Delete</button>
            <button @click="onSpam">Spam</button>
        </section>
        <!-- 商品信息 -->
        <section class="read-main-card">
            <div class="read-main-card-date">
                <div class="read-main-card-date-time">
                    <span>Time:</span>
                    <span class="read-main-card-date-time-text">{{ dayjs(infoData.send_at.date).format('MMM DD,YYYY HH:mm') }}</span>
                </div>
                <div class="read-main-card-date-address">
                    <span>IP Address:</span>
                    <span  class="read-main-card-date-address-text">
                        <v-img width="26" height="17" :imgSrc="infoData.send_country == 'cn' ? require('@/assets/img/china.png') : require('@/assets/img/kenya.png')" class="read-main-card-date-address-text-ip"></v-img>
                        
                        <span>{{ infoData.send_from_ip }}</span>
                    </span>
                </div>
            </div>
            <div class="read-main-card-from">
                <span>From:</span>
                <span>
                    <span class="read-main-card-from-text">{{ infoData.send_by_name }}</span>
                    <v-img width="26" height="17" :imgSrc="infoData.send_country == 'cn' ? require('@/assets/img/china.png') : require('@/assets/img/kenya.png')"></v-img>
                </span>
            </div>
            <div class="read-main-card-subject">
                <span>Subject:</span>
                <span>{{ infoData.subject }}</span>
            </div>
            <div class="read-main-card-figure">
                <v-img width="64" height="64" :imgSrc="require('@/assets/img/china.png')"></v-img>
                <div class="read-main-card-figure-parameter">
                    <p>Purchase Quantity:{{ infoData.purchase_quantity }}</p>
                    <!-- 额外要求 -->
                    <!-- <p>Extra Request:Price,Company Profile</p> -->
                    <p v-if="infoData.extra_request">Extra Request:{{infoData.extra_request}}</p>
                </div>
            </div>
        </section>
        <!-- 询问信息 -->
        <section class="read-main-info" v-html="infoData.content"></section>

        <section class="read-main-up" v-if="infoData.attachment_list">
            <div class="read-main-up-title">
                <v-img width="13" height="13" :imgSrc="require('@/assets/img/fj.png')"></v-img>
                <div class="read-main-up-title-file">
                    Attached
                    <span class="read-main-up-title-file-num">({{ infoData.attachment_list.length }} pieces)</span>
                </div>
                <!-- <template>
                    <Upload
                        class="read-main-up-title-file"
                        multiple
                        :before-upload="onUpBefore"
                        :show-upload-list="false"
                        action="//jsonplaceholder.typicode.com/posts/">
                        Attached
                        <span class="read-main-up-title-file-num">({{ 2 }} pieces)</span>
                    </Upload>
                </template> -->
            </div>
            <ul class="read-main-up-item">
                <li v-for="(item, index) of infoData.attachment_list" :key="index">
                    <v-img width="12" hegiht="12" imgSrc=""></v-img>
                    <span>{{ Object.keys(item)[0] }}</span>
                </li>
                <!-- <li>
                    <v-img width="12" hegiht="12" imgSrc=""></v-img>
                    <span>{{ 'attachment1.rar (17.2k)' }}</span>
                </li> -->
            </ul>
        </section>
    </div>
</template>

<script>
    import Img from '@/components/Img'
    import dayjs from 'dayjs'

    export default {
        data() {
            return {
                upObjs: [],
                infoData: {
                    send_at: {
                        date: '2019-01-25 15:04:11.000000'
                    },
                },
                infoQuery: {}
            }
        },
        methods: {
            dayjs: dayjs,
            onUpBefore(files) {
                let name = files.name.split('.')
                name = name[name.length - 1]
                // console.log(name)

                this.$set(this.upObjs, 0, {
                    name: files.name,
                    file: files,
                })
                return false
            },
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
                    }else {
                        this.$router.push('/inquiryList/send')
                    }
                }).catch(err => {
                    return false
                })
            },
            // 垃圾询盘
            onSpam() {
                let formData = new FormData()

                if(this.infoQuery.type == 'outbox') {
                    formData.append('messages_id_list[]', this.infoQuery.message_id)
                }else {
                    formData.append('messages_id_list[]', this.infoQuery.participant_id)
                }
                formData.append('action', 'mark')
                
                this.$request({
                    url: '/message/mark_spam_message',
                    method: 'post',
                    data: formData
                }).then(res => {
                    if(res.code == 200) {
                        this.$Message.info('Marked as spam inquiry');
                    }                    
                }).catch(err => {
                    console.log(err);
                })
            },
            // 删除
            onDelete() {
                let formData = new FormData();
                if(this.infoQuery.type == 'outbox') {
                    formData.append('messages_id_list[]', this.infoQuery.message_id)
                }else {
                    formData.append('messages_id_list[]', this.infoQuery.participant_id)
                }
                formData.append('type', this.infoQuery.type)
                formData.append('action', 'mark')

                this.$request({
                    url: '/message/mark_delete_message',
                    method: 'post',
                    data: formData,
                    headers:{'Content-Type':'multipart/form-data'}
                }).then(res => {
                    if(res.code == 200) {
                        this.$Message.info('Delete successful!')
                        this.$router.go(-1)
                    }else {
                        this.$Message.info('Delete failed!')
                    }
                }).catch(err => {
                    console.log(err)
                })
            }
        },
        mounted() {
            const query = this.$route.query
            this.GetData(query.type)
        },
        components: {
            'v-img': Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .read-main {
        .width(945px, auto);
        .bg-color(white);
        padding-top: 15px;
        align-self: flex-start;

        &-btn {
            margin-bottom: 16px;
            padding-left: 16px;

            & > button {
                border: none;
                width: 66px;
                height: 25px;
                background-color: #fff8f3;
                border: solid 1px #f0883a;
                font-size: 14px;
                line-height: 25px;
                color: #f0883a;
                margin-right: 13px;
            }

            & > &-active {
                background-color: #f0883a;
                color: #ffffff;
            }
        }

        &-card {
            width: 100%;
            height: 184px;
            background-color: #e9e9ed;
            padding-top: 10px;
            padding-left: 16px;

            &-date {
                .flex();
                margin-bottom: 10px;

                &-time, &-address {
                    font-size: 14px;
                    line-height: 15.5px;
                    color: #333333;
                    margin-right: 50px;
                    .flex();

                    &-text {
                        font-size: 14px;
                        color: #666666;
                        margin-left: 8px;
                        .flex();

                        &-ip {
                            position: relative;
                            top: -2px;
                        }
                        & > span:last-of-type {
                            margin-left: 8px;
                        }
                    }
                }
            }

            &-from, &-subject {
                font-size: 14px;
                line-height: 1;
                color: #333333;
                .flex();
                margin-bottom: 30px;

                & > span:last-of-type {
                    .flex();
                    color: #666666;
                    margin-left: 8px;
                    margin-right: 13px;
                }

                &-text {
                    margin-right: 13px;
                }
            }

            &-subject {
                margin-bottom: 15px;
            }

            &-figure {
                .flex();

                & > &-parameter {
                    .flex(center, flex-start, column);
                    margin-left: 18px;
                    font-size: 14px;
                    line-height: 1;
                    color: #666666;

                    & > p:first-of-type {
                        margin-bottom: 11px;
                    }
                }
            }
        }

        &-info {
            width: 943px;
            height: 102px;
            background-color: #ffffff;
            padding: 28px 22px;
            font-size: 14px;
            line-height: 2;
            color: #666666;
        }

        &-up {
            width: 100%;
            height: auto;
            background-color: #ffffff;
            border-top: 20px solid #f5f5f9;

            &-title {
                .flex(flex-start, center);
                height: 38px;
                background-color: #e9e9ed;
                padding-left: 20px;
                
                &-file {
                    cursor: pointer;
                    font-size: 16px;
                    line-height: 38px;
                    color: #666666;
                    height: 38px;
                    padding: 0px 8px 0px 3px;
                    transition: all 0.2s;

                    &-num {
                        color: #f0883a;
                    }
                }

                &-file:hover {
                    color: #f0883a;
                }
                
            }

            &-item {
                padding: 20px 39px;

                & > li {
                    .flex();
                    & > span:last-of-type {
                        font-size: 14px;
                        line-height: 2;
                        color: #999999;
                        margin-left: 6px;
                    }
                }
            }
        }
    }
</style>