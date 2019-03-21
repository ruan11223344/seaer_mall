<template>
    <div>
        <!-- 侧边栏 -->
        <v-aside></v-aside>
        
        <!-- 公司介绍 -->
        <section class="company-home-main-fixed" v-if="Company_Detail">
            <!-- logo -->
            <div class="company-home-main-fixed-head">
                <img :src="Company_Detail.shop_info.avatar_url" alt="">
            </div>
            <!-- 名称 -->
            <div class="company-home-main-fixed-name">{{ Company_Detail.basic_info.contact_full_name }}</div>
            <div class="company-home-main-fixed-content">
                <div>Company Name:</div>
                <Tooltip :content="Company_Detail.basic_info.company_name">
                    <p class="company-home-main-fixed-content-p">
                        {{ Company_Detail.basic_info.company_name }}
                    </p>
                </Tooltip>
            </div>
            <div class="company-home-main-fixed-state">
                <span>Country/Region:</span>
                <!-- <v-img width="28" height="18" :imgSrc="require('@/assets/img/china.png')" style="marginLeft: 8px;marginRight: 5px"></v-img> -->
                <img style="width:28px; height:18px;" :src="Company_Detail.basic_info.country_name == 'China' ? require('@/assets/img/china.png') : require('@/assets/img/kenya.png')" alt="">
                <span>{{ Company_Detail.basic_info.country_name }}</span>
            </div>
            <button class="company-home-main-fixed-btn" @click="onClick">
                <Icon type="ios-mail" size="24"/>
                Contact Now
            </button>
        </section>
    </div>
</template>

<script>
    import Img from '@/components/Img'
    import Aside from '../components/Aside/index.vue'
    import { mapState, mapMutations } from "vuex"
    import CompanyInfo from '@/components/CompanyInfo/index.vue'
    import Cookies from '@/utils/auth'
    
    export default {
        computed: {
            ...mapState([ 'Company_Detail' ])
        },
        data() {
            return {
                user: null
            }
        },
        methods: {
            getSessionStorage: Cookies.getSessionStorage,
            onClick() {
                this.$router.push('/goods/consulting?af_id=' + this.Company_Detail.shop_info.af_id + '&contactCompany=true')
            }
        },
        created() {
            this.user = this.getSessionStorage()
        },
        components: {
            "v-img": Img,
            "v-aside": Aside,
            'v-company-info': CompanyInfo,
        }
    }
</script>

<style lang="less" scoped>
    @import url("../../../assets/css/index");

    .company-home-main-fixed {
        .flex(center, center, column);
        margin-top: 19px;
        padding: 14px 16px;
        padding: top;
        width: 230px;
        height: 313px;
        background-color: #ffffff;
        border: solid 1px #eeeeee;

        &-head {
            width: 81px;
            height: 81px;
            background-color: #ffffff;
            border: solid 1px #dddddd;
            border-radius: 50%;

            & > img {
                width: 81px;
                height: 81px;
                border-radius: 50%;
            }
        }

        &-name {
            width: 100%;
            font-family: AdobeHeitiStd-Regular;
            font-size: 20px;
            line-height: 1;
            color: #333333;
            margin-top: 15px;
            text-align: center;
        }

        &-content {
            width: 100%;
            margin-top: 15px;

            & > div:first-child {
                font-size: 16px;
                font-weight: normal;
                font-stretch: normal;
                line-height: 15.5px;
                letter-spacing: 0px;
                color: #333333;
            }

            &-p {
                font-size: 14px;
                letter-spacing: 0px;
                color: #666666;
                overflow: hidden;
                .textHiddens(2);
            }
            
        }

        &-state {
            width: 100%;
            margin-top: 20px;
            .flex();
            
            & > span:first-child {
                font-size: 16px;
                line-height: 16px;
                color: #333333;
            }
            & > span:last-child {
                font-size: 16px;
                line-height: 16px;
                color: #333333;
                position: relative;
                top: 1px;
            }
        }

        &-btn {
            margin-top: 26px;
            border: none;
            width: 192px;
            height: 33px;
            background-color: #ef873a;
            font-size: 14px;
            font-weight: normal;
            font-stretch: normal;
            line-height: 15.5px;
            letter-spacing: 0px;
	        color: #ffffff;
        }
    }
</style>
