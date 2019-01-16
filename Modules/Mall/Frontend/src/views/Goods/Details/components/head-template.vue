<template>
    <div class="details-head">
        <header class="container details-head-container">
            <v-img width="181" height="53" :imgSrc="require('@/assets/img/home/logo.png')"></v-img>
            <h1>WuHan sier International cn.,LTD sier International cn.,LTD</h1>
            <div class="details-head-container-collection">
                <v-img width="" hegiht="" :imgSrc="require('@/assets/img/details/sc1.png')" class="details-head-container-collection-icon"></v-img>
                <span>Favorites Supplier</span>
            </div>
        </header>
    </div>
</template>

<script>
    import Img from '@/components/Img'

    export default {
        components: {
            'v-img': Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .details-head {
        width: 100%;
        height: 100px;
        background-color: #ffffff;

        &-container {
            height: 100px;
            .flex(space-between, center);

            & > h1 {
                font-size: 22px;
                font-weight: normal;
                font-stretch: normal;
                line-height: 1;
                letter-spacing: 0px;
                color: #666666;
            }

            &-collection {
                .flex(space-around, center);
                width: 157px;
                height: 29px;
                border: solid 1px #f0883a;
                font-size: 14px;
                line-height: 1;
                color: #f0883a;
                padding: 0px 5px;

                &-icon {
                    position: relative;
                    top: -1px;
                    cursor: pointer;
                }
            }
        }
    }
</style>
