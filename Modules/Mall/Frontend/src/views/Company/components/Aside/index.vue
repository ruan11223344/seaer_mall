<template>
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
                    <ul class="inquire-aside-items" :style="{ height: item.isSubShow ? item.subItems.length * 36 + 'px' : ''  }">
                        <router-link :style="{ color: $route.path == path ? '#f0883a' : ''}" v-for="({name, path}, i) in item.subItems" :key="i" :to="path ? path : ''" tag="li">{{ name }}</router-link>
                    </ul>
                </li>
            </ul>
        </aside>
    </aside>
</template>

<script>    
    import Img from "@/components/Img"

    export default {
        data() {
            return {
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
    @import url('../../../../assets/css/index.less');

    .company-home-main-aside {
        width: 228px;
        .bg-color(white);
        padding: 30px 19px;
        
        &-title {
            .flex();
            font-size: 16px;
            line-height: 1;
            color: #ef873a;
            cursor: pointer;
            
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
                line-height: 1.1;
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
