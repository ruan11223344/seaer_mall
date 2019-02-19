<template>
    <nav class="company-nav">
        <ul class="container company-nav-item">
            <router-link to="/company/home" tag="li" class="company-nav-item-list">
                Home
                <span class="company-nav-item-list-hr"></span>
            </router-link>
            <li class="company-nav-item-list company-nav-item-list-hover" @mouseover="products=true" @mouseout="products=false">
                Products
                <Icon type="ios-arrow-down" color="white"/>
                <div class="company-nav-item-list-hover-children" v-show="products">
                    <span>Building materials</span>
                    <span>Building materials</span>
                </div>
            </li>
            <router-link to="/2" tag="li" class="company-nav-item-list">
                About us
                <span class="company-nav-item-list-hr"></span>
            </router-link>
            <router-link to="/company/contact" tag="li" class="company-nav-item-list">
                Coutact us
                <span class="company-nav-item-list-hr"></span>
            </router-link>
        </ul>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                products: false
            }
        },
        methods: {
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

        &-item {
            .flex();

            &-list {
                .color(white);
                .lineHeight(50px);
                font-size: 16px;
                margin-right: 110px;
                cursor: pointer;
                position: relative;
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
                bottom: 0px;
            }
        }
    }
</style>
