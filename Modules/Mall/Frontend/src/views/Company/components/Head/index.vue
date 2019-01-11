<template>
    <div class="company-head">
        <!-- 公司logo -->
        <main class="container company-head-content">
            <v-img width="138" height="92" :imgSrc="require('@/assets/img/home/banner.png')"></v-img>
            <h1 class="company-head-content-title">WuHan sier International cn.,LTD sier International cn.,LTD</h1>
            <div class="company-head-content-collection">
                <v-img width="13" height="12" :imgSrc="require('@/assets/img/details/sc2.png')" class="company-head-content-collection-sc"></v-img>
                <span> Favorites Supplier</span>
            </div>
        </main>
    </div>
</template>

<script>
    import Img from "@/components/Img/index.vue"

    export default {
        components: {
            "v-img": Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');


    .company-head {
        .layout(150px);
        background-color: #fcfcfc;
        border: solid 1px #dddddd;

        &-content {
            .flex(flex-start, center);
            height: 100%;

            &-title {
                margin-left: 42px;
                margin-right: 244px;
                font-family: ArialMT;
                font-size: 22px;
                font-weight: normal;
                line-height: 1;
                color: #666666;
            }

            &-collection {
                .flex(center, center);
                .width(157px, 29px);
                line-height: 1;
                border: solid 1px #f0883a;
                color: #f0883a;

                &-sc {
                    position: relative;
                    top: -1px;
                    margin-right: 8px;
                    cursor: pointer;
                }
            }
        }
    }
</style>
