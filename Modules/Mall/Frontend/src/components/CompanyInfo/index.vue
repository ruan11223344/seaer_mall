<template>
    <div class="main-goods-right">
        <figure class="main-goods-right-head">
            <img :src="Company_Detail.shop_info.avatar_url" alt="">
            <figcaption>{{  Company_Detail.basic_info.contact_full_name }}</figcaption>
        </figure>
        <article class="main-goods-right-content">
            <h1>Company Name:</h1>
            <p>
                <Tooltip :content="Company_Detail.basic_info.company_name">
                    {{ Company_Detail.basic_info.company_name }}
                </Tooltip>
            </p>

            <div class="main-goods-right-content-Country">
                <div>Country:</div>
                <div>
                    <img :src="Company_Detail.basic_info.country_name == 'China' ? require('@/assets/img/china.png') : require('@/assets/img/kenya.png')" alt="">
                </div>
                <span>{{ Company_Detail.basic_info.country_name }}</span>
            </div>

            <div class="main-goods-right-content-business">
                <div>Business Type:</div>
                
                <div>
                    <Tooltip :content="Company_Detail.basic_info.business_type">
                        {{ Company_Detail.basic_info.business_type }}
                    </Tooltip>
                </div>
            </div>

        </article>
        <div class="main-goods-right-footer" @click="onSubmitEmail">
            <Icon type="ios-mail" size="24"/>
            <span>
                Contact Now
            </span>
        </div>
    </div>
</template>

<script>
    import getData from "@/utils/getData"
    import { mapState, mapMutations } from "vuex"

    export default {
        data() {
            return {
            }
        },
        computed: {
            ...mapState([ 'Company_Detail' ])
        },
        methods: {
            onSubmitEmail() {
                this.$Message.warning('暂时无法联系该公司')
            }
        },
        mounted() {
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .main-goods-right {
        .width(273px, 349px);
        .bg-color(light);
        border: solid 1px #eeeeee;

        &-head {
            padding-top: 14px;
            height: 117px;
            margin-bottom: 23px;

            & > img {
                .width(81px, 81px);
                display: block;
                margin: 0px auto;
                margin-bottom: 15px;
                border-radius: 50%;
                border: solid 1px #dddddd;
            }

            & > figcaption {
                .color(blackDark);
                height: 21px;
                font-size: 20px;
                line-height: 1;
                letter-spacing: 0px;
                text-align: center;
            }
        }

        &-content {
            padding-left: 16px;
            width: 244px;

            & > h1 {
                .color(blackDark);
                font-size: 16px;
            }

            & > p {
                .color(blackLight);
                font-size: 14px;
                height: 40px;
                .textHiddens(2);
            }

            &-Country {
                margin-top: 16px;
                .flex(flex-start, center);

                div:first-child {
                    width: 110px;
                    .color(blackDark);
                    font-size: 16px;
                    line-height: 1;
                    text-align: right;
                }
                div:nth-child(2) {
                    width: 28px;
                    height: 18px;
                    margin: 0px 5px 0px 8px;
                    position: relative;

                    & > img {
                        width: 100%;
                        position: absolute;
                        top: -2px;
                        left: -3px;
                    }
                }
                div:last-child {
                    .color(blackLight);
                    font-size: 11.8px;
                    letter-spacing: 0px;
                }
            }

            &-business {
                margin-top: 16px;
                .flex(flex-start, center);
                div:first-child {
                    text-align: right;
                    width: 110px;
                    .color(blackDark);
                    font-size: 16px;
                    line-height: 1;
                    margin-right: 5px;
                }

                div:last-child {
                    font-size: 10px;
                    line-height: 1;
                    letter-spacing: 0px;
                    color: #666666;
                    .textHidden();
                }
            }
        }

        &-footer {
            .lineHeight(33px);
            .color(white);
            .bg-color(orange2);
            width: 242px;
            margin: 0px auto;
            margin-top: 17px;
            letter-spacing: 0px;
            text-align: center;
            cursor: pointer;
        }
    }
</style>
