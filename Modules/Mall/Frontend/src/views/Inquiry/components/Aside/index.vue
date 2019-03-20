<template>
    <aside class="inquire-aside" :style="$route.path == '/inquiryList/personalpenter' ? 'height: 555px' : ''">
        <ul>
            <li v-for="(item, index) in menuList" :key="index">
                <div ref="menuList" class="inquire-aside-title" @click="onClick(item,index)">
                    <span>
                        <!-- {{ $route.path.split('/').includes('administration') }} -->
                        {{ item.name }}
                    </span>
                    <Icon type="ios-arrow-forward" style="transition: all 0.2s;" :style="{transform: item.isSubShow ? 'rotate(90deg)' : 'rotate(0deg)' }"/>
                </div>
                <ul class="inquire-aside-items" :style="{ height: item.isSubShow ? item.subItems.length * 35 + 'px' : ''  }">
                    <!-- <router-link :style="{ color: $route.path == path ? '#f0883a' : ''}" v-for="({name, path}, i) in item.subItems" :key="i" :to="path ? path : ''" tag="li">{{ name }}</router-link> -->
                    <router-link :style="{ color: $route.path.split('/').includes(path) ? '#f0883a' : ''}" v-for="({name, path, url}, i) in item.subItems" :key="i" :to="url ? url : ''" tag="li">{{ name }}</router-link>
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
                                name:'User center',
                                path: 'personalpenter',
                                url: '/inquiryList/personalpenter'
                            },
                            {
                                name:'Account Info',
                                path: 'account',
                                url: '/inquiryList/account/accountinfo'
                            },
                            {
                                name:'Company Info',
                                path: 'company',
                                url: '/inquiryList/company/companyinfo',
                            },
                            {
                                name:'Change Password',
                                path: 'changepass',
                                url: '/inquiryList/changepass'
                            },
                            {
                                name:'Edit My Photo',
                                path: 'picture',
                                url: '/inquiryList/picture',
                            },
                            {
                                name: 'Notice',
                                path: 'notice',
                                url: '/inquiryList/notice',
                            }
                        ]
                    },
                    {
                        name:'Shop Management',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Shop Settings',
                                url: '/inquiryList/management/bannerset',
                                path: 'bannerset'
                            },
                            {
                                name:'Store Dynamics',
                                url: '/inquiryList/management/dynamics',
                                path: 'dynamics'
                            }
                        ]
                    },
                    {
                        name:'Products',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Upload Product',
                                url: '/inquiryList/uploadroot/uploadproduct',
                                path: 'uploadroot',
                            },
                            {
                                name:'Manage Products',
                                url: '/inquiryList/commodity/operation',
                                path: 'commodity'
                            },
                            {
                                name:'Manage Photos',
                                url: '/inquiryList/Album/administration',
                                path: 'Album'
                            },
                            {
                                name:'Group & Sort Products',
                                url: '/inquiryList/SortProducts',
                                path: 'SortProducts'
                            }
                        ]
                    },
                    {
                        name:'Inquiries',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Inbox',
                                url: '/inquiryList/inbox',
                                path: 'inbox',
                            },
                            {
                                name:'Sent',
                                url: '/inquiryList/send',
                                path: 'send',
                            },
                            {
                                name:'Flag Inquiry',
                                url: '/inquiryList/flag',
                                path: 'flag',
                            },
                            {
                                name:'Delete Inquiry',
                                url: '/inquiryList/del',
                                path: 'del'
                            },
                            {
                                name:'Spam Report Inquiry',
                                url: '/inquiryList/spam',
                                path: 'spam',
                            },
                            {
                                name:'Inquiry Rules',
                                url: '/inquiryList/set',
                                path: 'set'
                            }
                        ]
                    },
                    {
                        name:'Favorite',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Collection',
                                url: '/inquiryList/collection',
                                path: 'collection',
                            }
                        ]
                    },
                    {
                        name:'Service Center',
                        isSubShow:false,
                        subItems:[
                            {
                                name:'Rule Center',
                                url: '/notice?key=Rule Center'
                            },
                            {
                                name:'Service Account Center',
                                url: '/notice?key=Service Account Center'
                            }
                        ]
                    },
                ]
            }
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
                    // if(v.path == path) {
                    //     value.isSubShow = true
                    // }
                    if(path.split('/').includes(v.path)) {
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
