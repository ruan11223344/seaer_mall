<template>
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
</template>

<script>
    export default {
        data() {
            return {
                menuList: [
                    {
                        name:'Account Center',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Account Info'
                            },
                            {
                                name:'Company Info',
                                path: '/inquiryList/companyinfo'
                            },
                            {
                                name:'Change Password'
                            },
                            {
                                name:'Edit My Photo',
                                path: '/inquiryList/picture'
                            }
                        ]
                    },
                    {
                        name:'Shop Management',
                        isSubShow:false,
                        subItems:[
                            {
                                // name:'Shop Settings'
                                name:'Shop Settings'
                            },
                            {
                                name:'Store Dynamics'
                            }
                        ]
                    },
                    {
                        name:'Products',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Upload Product'
                            },
                            {
                                name:'Manage Products'
                            },
                            {
                                name:'Manage Photos'
                            },
                            {
                                name:'Group & Sort Products'
                            }
                        ]
                    },
                    {
                        name:'Inquiries',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Inbox',
                                path: '/inquiryList/inbox'
                            },
                            {
                                name:'Sent',
                                path: '/inquiryList/send'

                            },
                            {
                                name:'Flag Inquiry',
                                path: '/inquiryList/flag'
                            },
                            {
                                name:'Delete Inquiry',
                                path: '/inquiryList/del'
                            },
                            {
                                name:'Spam Report Inquiry',
                                path: '/inquiryList/spam'
                            },
                            {
                                name:'Inquiry Rules',
                                path: '/inquiryList/set'
                            }
                        ]
                    },
                    {
                        name:'Favorite',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Products',
                                path: '/inquiryList/collection'
                            },
                            {
                                name:'Suppliers'
                            }
                        ]
                    },
                    {
                        name:'Service Center',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Shop Settings'
                            },
                            {
                                name:'Store Dynamics'
                            }
                        ]
                    },
                ]
            }
        },
        props: {

        },
        methods: {
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

    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .inquire-aside {
        align-self: flex-start;
        .width(255px, 772px);
        .bg-color(white);
        padding: 6px 18px;
        overflow: hidden;

        &-title {
            font-size: 16px;
            line-height: 1;
            color: #333333;
            .flex();
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
            }

            & > li:hover {
                color: #f0883a;
            }
        }
        
    }
    
    
   
</style>
