<template>
    <nav class="company-nav">
        <ul class="container company-nav-item">
            <router-link :to="'/company/home?company_id=' + $route.query.company_id" tag="li" class="company-nav-item-list">
                Home
                <span class="company-nav-item-list-hr"></span>
            </router-link>
            <li class="company-nav-item-list company-nav-item-list-hover">
                <Dropdown style="margin-left: 20px" @on-click="onClick">
                    <a href="javascript:void(0)" style="color: #fff">
                        Products
                        <Icon type="ios-arrow-down"></Icon>
                    </a>
                    <template v-if="Company_Detail">
                        <template v-if="Company_Detail.shop_info.shop_group.length">
                            <DropdownMenu slot="list">
                                <DropdownItem
                                    v-for="(item, index) in Company_Detail.shop_info.shop_group"
                                    :key="index"
                                    :name="item.group_name + ' ' + item.id"
                                    >
                                    {{ item.group_name }}
                                </DropdownItem>
                            </DropdownMenu>
                        </template>
                    </template>
                </Dropdown>
            </li>
            <router-link :to="'/company/profile?company_id=' + $route.query.company_id" tag="li" class="company-nav-item-list">
                About us
                <span class="company-nav-item-list-hr"></span>
            </router-link>
            <router-link :to="'/company/contact?company_id=' + $route.query.company_id" tag="li" class="company-nav-item-list">
                Coutact us
                <span class="company-nav-item-list-hr"></span>
            </router-link>
        </ul>
    </nav>
</template>

<script>
    import { mapState } from "vuex"

    export default {
        data() {
            return {
                products: false
            }
        },
        computed: {
            ...mapState([ 'Company_Detail' ])
        },
        methods: {
            onClick(value) {
                const arr = value.split(' ')
                this.$router.push(`/company/all?group_id=${arr[1]}&company_id=${this.$route.query.company_id}&group_name=${arr[0]}`)
            }
        },
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .company-nav {
        width: 100%;
        min-width: 1220px;
        height: 50px;
        background-color: #666666;
        position: relative;
        z-index: 10000;

        &-item {
            .flex();

            &-list {
                .color(white);
                .lineHeight(50px);
                font-size: 16px;
                margin-right: 110px;
                cursor: pointer;
                position: relative;
                z-index: 10000;
            }

            &-list-hover {
                &-children {
                    .flex(space-around, center, column);
                    position: absolute;
                    left: 0px;
                    width: 143px;
                    color: #666666;
                    background-color: #ffffff;
                    border: solid 1px #dddddd;
                    z-index: 10000;
                    font-size: 14px;
                    
                    & > span {

                    }
                }
            }

            .router-link-active > .company-nav-item-list-hr  {
                .width(100%, 1px);
                .bg-color(white);
                position: absolute;
                left: 50%;
                bottom: 0px;
                transform: translateX(-50%);
            }
        }
    }
</style>
