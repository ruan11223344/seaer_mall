<template>
    <aside class="inquire-aside" :style="{ 'height': height }">
        <h1 class="inquire-aside-title">
            <img :src="require('@/assets/img/home/weidu.png')" alt="" class="inquire-aside-title-logo">
            Inquiries
        </h1>
        <router-link class="inquire-aside-list" to="/inquiryList/inbox" tag="div">Inbox</router-link>
        <router-link class="inquire-aside-list" to="/inquiryList/send" tag="div">Sent</router-link>
        <div class="inquire-aside-list">Flay Inquiry</div>
        <div class="inquire-aside-list">Deleted Inquiry</div>
        <div class="inquire-aside-list">Span Reported Inquiry</div>
        <router-link class="inquire-aside-list" to="/inquiryList/set" tag="div">Inquiry Rules</router-link>
    </aside>
</template>

<script>
    export default {
        props: {
            height: {
                default: '700px'
            }
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .inquire-aside {
        .width(255px, 700px);
        .bg-color(white);
        padding: 34px 18px;

        &-title {
            .color(orange2);
            line-height: 1;
            font-weight: bold;
            font-size: 16px;

            &-logo {
                position: relative;
                top: 2px;
                margin-right: 12px;
            }
        }

        &-list {
            .color(blackLight);
            .textHidden();
            width: 100%;
            font-size: 16px;
            line-height: 1;
            margin-top: 30px;
            cursor: pointer;
        }
        &-list:hover {
            .color(orange2);
        }
    }

    .router-link-active {
        .color(Orange);
    }
</style>
