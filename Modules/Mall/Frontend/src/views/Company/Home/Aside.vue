<template>
    <div>
        <!-- 侧边栏 -->
        <!-- <aside class="company-home-main-aside"  :style="{ height: (81 + 16 * aside.length + 26 * aside.length - 1) + 'px' }"> -->
        <aside class="company-home-main-aside">
            <div class="company-home-main-aside-title"> 
                <v-img width="21" height="15" :imgSrc="require('@/assets/img/icon/fenlei.png')" class="company-home-main-aside-title-icon"></v-img>
                All Products
            </div>

            <aside class="inquire-aside">
                <ul>
                    <li v-for="(item, index) in menuList" :key="index">
                        <div ref="menuList" class="inquire-aside-title" @click="onClick(item,index)">
                            <span>
                                {{ item.name }}
                            </span>
                            <Icon type="ios-arrow-forward" style="transition: all 0.2s;" :style="{transform: item.isSubShow ? 'rotate(90deg)' : 'rotate(0deg)' }"/>
                        </div>
                        <ul class="inquire-aside-items" :style="{ height: item.isSubShow ? item.subItems.length * 35 + 'px' : ''  }">
                            <router-link :style="{ color: $route.path == path ? '#f0883a' : ''}" v-for="({name, path}, i) in item.subItems" :key="i" :to="path ? path : ''" tag="li">{{ name }}</router-link>
                        </ul>
                    </li>
                </ul>
            </aside>
        </aside>
        
        <!-- 公司介绍 -->
        <section class="company-home-main-fixed">
            <!-- logo -->
            <div class="company-home-main-fixed-head"></div>
            <!-- 名称 -->
            <div class="company-home-main-fixed-name">Mr. Nancy</div>
            <div class="company-home-main-fixed-content">
                <div>Company Name:</div>
                <p>WuHan sier International cn.,LTD sier International cn.,LTD</p>
            </div>
            <div class="company-home-main-fixed-state">
                <span>Country/Region:</span>
                <v-img width="28" height="18" :imgSrc="require('@/assets/img/china.png')" style="marginLeft: 8px;marginRight: 5px"></v-img>
                <span>china</span>
            </div>
            <button class="company-home-main-fixed-btn" @click="isShade=true">
                <Icon type="ios-mail" size="24"/>
                Contact Now
            </button>
        </section>
        <!-- 模态框 -->
        <section class="company-home-main-shade" @click="isShade=false" v-show="isShade"></section>
        <div class="company-home-main-dialog" v-show="isShade">
            <!-- 关闭 -->
            <div class="company-home-main-dialog-close" @click="isShade=false">
                <Icon type="md-close" size="28"/>
            </div>
            <h1 class="company-home-main-dialog-title">Send your message to this supplier</h1>
            <div class="company-home-main-dialog-email">From: 522151521@qq.com</div>
            <div class="company-home-main-dialog-name">
                To:
                <v-img width="26" height="18" imgSrc=""></v-img>
                {{ 'Mr.mary' }}
            </div>
            <div class="company-home-main-dialog-content">
                <textarea v-model="text" @focus="onFocus" @blur="onBlur"></textarea>
                <span>({{ this.text.length }}/4000)</span>
            </div>
            
            <button class="company-home-main-dialog-btn">send</button>
        </div>
    </div>
</template>

<script>
    import Img from '@/components/Img'

    export default {
        data() {
            return {
                text: 'We suggest you detail your preduct requirements and company information here(Enter between 20-4000characters)',
                aside: [
                    'Building materials',
                    'Building materials',
                    'Building materials',
                    'Building materials',
                ],
                isShade: false,
                menuList: [
                    {
                        name:'Account Center',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Building materials123'
                            },
                            {
                                name:'Building materials',
                                // path: '/inquiryList/companyinfo'
                            },
                            {
                                name:'Building materials'
                            },
                            {
                                name:'Building materials',
                                // path: '/inquiryList/picture'
                            }
                        ]
                    },
                    {
                        name:'Account Center',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Building materials'
                            },
                            {
                                name:'Building materials'
                            }
                        ]
                    },
                ]
            }
        },
        methods: {
            onFocus() {
                this.text == 'We suggest you detail your preduct requirements and company information here(Enter between 20-4000characters)' ? this.text = '' : ''
            },
            onBlur() {
                this.text.length > 0 ? '' : this.text = 'We suggest you detail your preduct requirements and company information here(Enter between 20-4000characters)'
            },
            onClick(item, index) {
                this.menuList.forEach((i,inx) => {
                    if (inx !== index) {
                        i.isSubShow = false;
                    }else {
                        i.isSubShow = true;
                    }
                });
            },
        },
        mounted() {
            const path = this.$route.path
            this.menuList.forEach(value => {
                value.subItems.forEach(v => {
                    if(v.path == path) {
                        value.isSubShow = true
                    }
                })
            })
        },
        components: {
            "v-img": Img
        }
    }
</script>

<style lang="less" scoped>
    @import url("../../../assets/css/index");

    .company-home-main-aside {
        width: 228px;
        .bg-color(white);
        padding: 30px 19px;
        
        &-title {
            .flex();
            font-size: 16px;
            line-height: 1;
            color: #ef873a;

            &-icon {
                margin-right: 11px;
            }
        }

        &-item {
            width: 100%;
            margin-top: 35px;

            &-list:first-child {
                margin-top: 0px;
            }

            &-list {
                width: 100%;
                font-size: 16px;
                line-height: 1;
                letter-spacing: 0px;
                color: #666666;
                margin-top: 26px;
                cursor: pointer;
            }

            &-list:hover {
                color: #f0883a;
            }
        }
    }

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

            & > p {
                font-size: 14px;
                letter-spacing: 0px;
                color: #666666;
                .textHiddens(2);
            }
            
        }

        &-state {
            width: 100%;
            margin-top: 20px;
            .flex();

            & > span:first-child {
                font-size: 16px;
                font-weight: normal;
                font-stretch: normal;
                line-height: 15.5px;
                letter-spacing: 0px;
                color: #333333;
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
    
    .company-home-main-shade {
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }

    .company-home-main-dialog {
        padding: 34px;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 847px;
        height: 655px;
        background-color: #ffffff;
        z-index: 10000;

        &-close {
            position: absolute;
            top: 16px;
            right: 24px;
            cursor: pointer; 
        }

        &-title {
            font-size: 20px;
            font-weight: normal;
            font-stretch: normal;
            line-height: 1;
            letter-spacing: 0px;
            color: #333333;
        }

        &-email {
            margin-top: 33px;
            margin-bottom: 18px;
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            line-height: 1;
            letter-spacing: 0px;
            color: #666666;
        }
        &-name {
            .flex();
            font-size: 16px;
            line-height: 1;
            color: #666666;
            padding-left: 20px;
        }

        &-content {
            position: relative;
            margin-top: 14px;
            margin-bottom: 75px;

            & > textarea {
                width: 783px;
                height: 341px;
                border: solid 1px #dddddd;
                resize: none;
                font-size: 14px;
                font-weight: normal;
                font-stretch: normal;
                line-height: 2;
                letter-spacing: 0px;
                color: #cccccc;
                padding: 0px 20px;
            }

            &::before {
                content: 'Your inquiry content must be between 20 to 4000characters';
                font-size: 13px;
                line-height: 1;
                color: #d72b2b;
                position: absolute;
                left: 0px;
                bottom: -22px;
            }

            & > span {
                position: absolute;
                right: 25px;
                bottom: 18px;
                font-size: 14px;
                line-height: 1;
                color: #999999;
            }
        }

        &-btn {
            .color(white);
            display: block;
            width: 133px;
            height: 39px;
            background-color: #f0883a;
            border: none;
            font-size: 18px;
            margin: 0px auto;
        }
    }

    .inquire-aside {
        align-self: flex-start;
        .bg-color(white);
        padding: 6px 18px;
        padding-left: 0px;
        overflow: hidden;

        &-title {
            .flex(space-between);
            font-size: 16px;
            line-height: 1;
            color: #333333;
            cursor: pointer;
            margin-top: 21px;
        }

        &-items {
            overflow: hidden;
            height: 0px;
            transition: height 0.2s;
            cursor: pointer;
            
            & > li {
                font-size: 14px;
                line-height: 1;
                color: #999999;
                margin-top: 21px;
                .textHidden();
            }

            & > li:hover {
                color: #f0883a;
            }
        }
        
    }
</style>
