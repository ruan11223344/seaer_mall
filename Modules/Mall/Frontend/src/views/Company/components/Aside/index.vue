<template>
    <aside class="company-home-main-aside">
        <div class="company-home-main-aside-title"> 
            <v-img width="21" height="15" :imgSrc="require('@/assets/img/icon/fenlei.png')" class="company-home-main-aside-title-icon"></v-img>
            All Products
        </div>
        <aside class="inquire-aside" v-if="menu != null">
            <ul>
                <li v-for="(item, index) in menu" :key="index">
                    <div ref="menuList" class="inquire-aside-title">
                        <router-link
                            tag="span"
                            :style="'color: ' + ($route.query.group_id == item.id ? '#f0883a' : '')"
                            :to="`/company/all?group_id=${item.id}&company_id=${$route.query.company_id}&group_name=${item.group_name}`"
                            >
                            {{ item.group_name }}
                        </router-link>
                        <Icon
                            v-if="item.children != null"
                            type="ios-arrow-forward"
                            style="transition: all 0.2s;" :style="{transform: item.isSubShow ? 'rotate(90deg)' : 'rotate(0deg)' }"
                            @click="onClick(item,index)"
                            />
                    </div>
                    <template  v-if="item.children != null">
                        <ul class="inquire-aside-items" :style="'height: ' + (item.isSubShow ? item.children.length * 36 + 'px;' : '0px;')">
                            <router-link
                                :style="'color: ' + ($route.query.group_id == id ? '#f0883a' : '')"
                                v-for="({ group_name, id }, i) in item.children"
                                :key="i"
                                :to="`/company/all?group_id=${id}&company_id=${$route.query.company_id}&group_name=${group_name}`"
                                tag="li">
                                    {{ group_name }}
                            </router-link>
                        </ul>
                    </template>
                </li>
            </ul>
        </aside>
    </aside>
</template>

<script>    
    import Img from "@/components/Img"
    import { mapState, mapMutations } from "vuex"

    export default {
        data() {
            return {
                menu: null
            }
        },
        computed: {
            ...mapState([ 'User_Info', 'Company_Detail' ]),
        },
        methods: {
            onClick(item, index) {
                this.menu.forEach((i,inx) => {
                    if (inx !== index) {
                        const obj = this.menu[inx]
                        obj.isSubShow = false
                        this.$set(this.menu, inx, obj)
                    }else {
                        const obj = item
                        obj.isSubShow = true
                        this.$set(this.menu, inx, obj)
                    }
                });
            },
        },
        mounted() {
            const id = this.$route.query.group_id
    
            this.Company_Detail.shop_info.shop_group.forEach(value => {
                if(value.children != null) {
                    value.children.forEach(v => {
                        if(v.id == id) {
                            value.isSubShow = true
                        }else {
                            value.isSubShow = false
                        }
                    })
                }
            })

            this.menu = this.Company_Detail.shop_info.shop_group
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
