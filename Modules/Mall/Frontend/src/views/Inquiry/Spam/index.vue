<template>
    <div class="Send-main">
        <v-title title="Spam Report Inquiry"></v-title>

        <section class="Send-main-screening">
            <div class="Send-main-screening-text Send-main-screening-text-active">ALL <span>10</span></div>
        </section>

        <div class="Send-main-btn">
            <button style="width: 112px;">Cancel  Spam</button>
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
