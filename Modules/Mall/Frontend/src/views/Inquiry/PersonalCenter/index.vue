<template>
    <div class="personal">
        <main class="personal-main">
            <div class="personal-main-left">
                <div class="personal-main-left-head" v-if="User_Info">
                    <img :src="User_Info.user_extends.avatar_url" alt="">
                    <dl>
                        <dt class="personal-main-left-head-title">CHENG-NANCY</dt>
                        <dd>(Member ID：{{ User_Info.user.name }})</dd>
                        <dt class="personal-main-left-head-free">Free Member</dt>
                        <dd>Membership</dd>
                    </dl>
                </div>

                <div class="personal-main-left-sent">
                    <div class="personal-main-left-sent-title">Sent</div>
                    <ul class="personal-main-left-sent-block">
                        <li>
                            All <span>{{ len.all.length }}</span>
                        </li>
                        <li>
                            Unread <span>{{ len.unread.length }}</span>
                        </li>
                        <li>
                            Not yet replied <span>{{ len.un_reply.length }}</span>
                        </li>
                    </ul>
                </div>

                <div class="personal-main-left-stone">
                    <div class="personal-main-left-stone-title">Stone and product tips</div>
                    <div class="personal-main-left-stone-p">Stone infomation and pending items than you need to pay attention to.</div>
                    <div class="personal-main-left-stone-block">
                        <div class="personal-main-left-stone-block-Product">
                            Product
                            <span>27/200</span>
                        </div>
                        <div class="personal-main-left-stone-block-Product">
                            Image
                            <span>1755/3000</span>
                        </div>
                    </div>
                    <div class="personal-main-left-stone-block">
                        <li>
                            Selling <span>10</span>
                        </li>
                        <li>
                            Check Pending <span>10</span>
                        </li>
                        <li>
                            Unapprove <span>10</span>
                        </li>
                        <li>
                            In the warehouse <span>10</span>
                        </li>
                    </div>
                </div>
            </div>
            <div class="personal-main-right">
                <div class="personal-main-right-Notice">
                    <div class="personal-main-right-Notice-title">
                        <span>Notice</span>
                        <span>More</span>
                    </div>
                    <p>Afriby Kenya invites you to join us!join...</p>
                    <p>2018 Dragon Boat Festival holiday ...</p>
                    <p>Kenya站开通进口服务，一对一海外采...</p>
                </div>
                <div class="personal-main-right-time">
                    <div class="personal-main-right-time-title">Time Difference</div>
                    <div class="personal-main-right-time-block">
                        <div class="personal-main-right-time-block-date">
                            <div>Kenya</div>
                            <time>Jan 16,2019, 10:56  AM</time>
                        </div>
                        <div class="personal-main-right-time-block-date">
                            <div>China</div>
                            <time>Jan 16,2019, 03:56  PM</time>
                        </div>
                    </div>
                </div>
                <div class="personal-main-right-currency">
                    <div class="personal-main-right-currency-title">Currency Converter</div>
                    <div class="personal-main-right-currency-money" v-if="!result">
                        {{ '100' }}  KSh = <span>{{ Oss_Url_Config.ksh100_to_cny }}</span>CNY
                    </div>
                    <div class="personal-main-right-currency-money" v-else>
                        {{ result.amount }}  {{ result.form == "KES" ? 'KSh' : 'CNY' }} = <span>{{ result.conversion }}</span>{{ result.to == "CNY" ? 'CNY' : 'KSh' }}
                    </div>
                    <div class="personal-main-right-currency-date">Updated on Jan 16, 2019</div>
                    <InputNumber size="small" :max="99999999" style="width: 241px; marginBottom: 10px;" v-model="formItem.number"></InputNumber>
                    <!-- <Input type="text" size="small"  ></Input> -->
                    <div class="personal-main-right-currency-num">
                        <div>{{ formItem.bool ? 'KSH' : 'CNY' }}</div>
                        <img class="personal-main-right-currency-num-img" @click="$set(formItem, 'bool', !formItem.bool)" :src="require('@/assets/img/huan.png')" alt="">
                        <div>{{ formItem.bool ? 'CNY' : 'KSH' }}</div>
                    </div>
                    <button class="personal-main-right-currency-btn" type="button" @click="onClick">Check</button>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import getData from "@/utils/getData.js"
    import upData from "@/utils/upData.js"
    import { mapState } from "vuex"
    
    export default {
        data() {
            return {
                len: {
                    all: [],
                    read: [],
                    unread: [],
                    un_reply: []
                },
                formItem: {
                    number: null,
                    bool: true
                },
                result: null
            }
        },
        computed: {
            ...mapState([ 'User_Info', 'Oss_Url_Config' ])
        },
        methods: {
            onGetOutboxMessag: getData.onGetOutboxMessag,
            onCurrency: upData.onCurrency,
            onClick() {
                this.onCurrency({
                    from: this.formItem.bool ? 'KES' : 'CNY',
                    to: this.formItem.bool ? 'CNY' : 'KES',
                    amount: this.formItem.number
                }).then(res => {
                    this.result = res
                })
            }
        },
        mounted() {
            this.onGetOutboxMessag()
                .then(res => {
                    this.len = res
                })
        },
        components: {
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .personal {
        align-self: flex-start;
        width: 944px;
        height: 772px;
        // background-color: #ffffff;
        // padding: 21px 30px;

        &-main {
            .flex(space-betwenn, flex-start);

            &-left {
                width: 657px;

                &-head {
                    width: 657px;
                    height: 180px;
                    background-color: #ffffff;
                    border: solid 1px #eeeeee;
                    .flex(flex-start, center);

                    & > img {
                        width: 122px;
                        height: 122px;
                        background-color: #eeeeee;
                        display: block;
                        border-radius: 50%;
                        margin-left: 22px;
                        margin-right: 30px;
                    }

                    &-title {
                        font-size: 20px;
                        color: #333333;
                        margin-bottom: 12px;
                    }

                    &-title + dd {
                        margin-bottom: 22px;
                    }

                    &-free {
                        font-size: 16px;
                        color: #666666;
                        margin-bottom: 10px;
                    }

                    &-title + dd, &-free + dd {
                        font-size: 14px;
                        color: #999999;
                    }

                    &-title, &-title + dd, &-free, &-free + dd {
                        line-height: 1;
                    }
                }

                &-sent {
                    width: 657px;
                    height: 121px;
                    background-color: #ffffff;
                    border: solid 1px #eeeeee;
                    margin-top: 10px;

                    &-title {
                        font-size: 18px;
                        line-height: 1;
                        color: #666666;
                        margin-top: 22px;
                        margin-left: 20px;
                    }

                    &-block {
                        width: 621px;
                        height: 47px;
                        background-color: #f5f5f9;
                        margin-top: 18px;
                        margin-left: 18px;
                        padding-left: 5px;

                        & > li {
                            height: 47px;
                            display: inline-block;
                            font-size: 14px;
                            line-height: 47px;
                            color: #666666;
                            position: relative;
                            margin: 0px 18px;
                            cursor: pointer;

                            & > span {
                                font-size: 14px;
                                color: #d72b2b;
                            }
                        }

                        & > li::after {
                            content: '';
                            width: 1px;
                            height: 11px;
                            background-color: #cccccc;
                            position: absolute;
                            top: 50%;
                            right: -18px;
                            transform: translateY(-50%);
                        }

                        & > li:last-child::after {
                            width: 0px;
                        }
                    }
                }

                &-stone {
                    width: 657px;
                    height: 234px;
                    background-color: #ffffff;
                    border: solid 1px #eeeeee;
                    margin-top: 10px;
                    padding-top: 24px;

                    &-title {
                        font-size: 18px;
                        line-height: 1;
                        color: #666666;
                        margin-left: 20px;
                    }
                    
                    &-p {
                        font-size: 14px;
                        line-height: 1;
                        color: #999999;
                        margin-top: 9px;
                        margin-left: 20px;
                    }

                    &-block {
                        width: 621px;
                        height: 47px;
                        background-color: #f5f5f9;
                        margin-top: 21px;
                        margin-left: 18px;

                        &-Product {
                            font-size: 14px;
                            line-height: 47px;
                            color: #666666;
                            display: inline-block;
                            margin-left: 24px;

                            & > span {
                                font-size: 14px;
                                line-height: 47px;
                                letter-spacing: 0px;
                                color: #d72b2b;
                                margin-left: 11px;
                            }
                        }

                        & > li {
                            height: 47px;
                            display: inline-block;
                            font-size: 14px;
                            line-height: 47px;
                            color: #666666;
                            position: relative;
                            margin: 0px 18px;
                            cursor: pointer;

                            & > span {
                                font-size: 14px;
                                color: #d72b2b;
                            }
                        }

                        & > li::after {
                            content: '';
                            width: 1px;
                            height: 11px;
                            background-color: #cccccc;
                            position: absolute;
                            top: 50%;
                            right: -18px;
                            transform: translateY(-50%);
                        }

                        & > li:last-child::after {
                            width: 0px;
                        }
                    }
                }
            }

            &-right {
                width: 279px;
                margin-left: 10px;
                
                &-Notice {
                    width: 279px;
                    height: 137px;
                    background-color: #ffffff;
                    border: solid 1px #eeeeee;
                    position: relative;

                    &-title {
                        width: 279px - 20px - 10px;
                        font-size: 18px;
                        line-height: 1;
                        color: #666666;
                        margin-top: 18px;
                        margin-left: 20px;
                        .flex(space-between);

                        & > span:last-child {
                            font-size: 14px;
                            line-height: 1;
                            color: #999999;
                        }
                    }

                    & > p {
                        width: 279px - 20px - 10px;
                        font-size: 12px;
                        line-height: 1;
                        color: #666666;
                        margin-top: 15px;
                        margin-left: 20px;
                        .textHidden();
                    }

                    &::before {
                        content: '';
                        width: 0;
                        height: 0;
                        border-top: 20px solid #f0883a;
                        border-right: 20px solid transparent;
                        position: absolute;
                        top: 0px;
                    }
                }

                &-time {
                    width: 279px;
                    height: 166px;
                    background-color: #ffffff;
                    border: solid 1px #eeeeee;
                    margin-top: 10px;
                    padding: 18px;

                    &-title {
                        font-size: 18px;
                        line-height: 1;
                        color: #666666;
                    }

                    &-block {
                        width: 240px;
                        height: 101px;
                        background-color: #f5f5f9;
                        margin-top: 16px;
                        padding: 11px 0px 11px 13px;

                        &-date {
                            & > div {
                                font-size: 14px;
                                line-height: 1.3;
                                color: #666666;
                            }

                            & > time {
                                font-size: 14px;
                                line-height: 21px;
                                color: #999999;
                            }
                        }
                    }
                }

                &-currency {
                    width: 279px;
                    height: 232px;
                    background-color: #ffffff;
                    border: solid 1px #eeeeee;
                    margin-top: 10px;
                    padding: 18px;
                    padding-bottom: 15px;

                    &-title {
                        font-size: 18px;
                        line-height: 1;
                        color: #666666;
                    }

                    &-money {
                        font-size: 14px;
                        line-height: 1;
                        color: #666666;
                        margin-top: 14px;
                        margin-bottom: 10px;

                        & > span {
                            font-size: 14px;
                            color: #d72b2b;
                        }
                    }

                    &-date {
                        font-size: 12px;
                        line-height: 1;
                        color: #999999;
                        margin-bottom: 14px;
                    }

                    &-num {
                        .flex(space-between, center);

                        &-img {
                            width: 16px;
                            height: 14px;
                            cursor: pointer;
                        }

                        & > div {
                            width: 101px;
                            height: 35px;
                            border: solid 1px #dddddd;
                            font-size: 14px;
                            line-height: 35px;
                            color: #666666;
                            text-align: center;
                        }
                    }

                    &-btn {
                        width: 241px;
                        height: 33px;
                        background-color: #ef873a;
                        font-size: 14px;
                        color: #ffffff;
                        border: none;
                        margin-top: 10px;
                    }
                }
            }
        }
    }

</style>
