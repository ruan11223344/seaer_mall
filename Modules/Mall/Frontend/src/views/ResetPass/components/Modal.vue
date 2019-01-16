<template>
    <div class="resetPass-modal">
        <v-img width="99" height="101" :imgSrc="require('@/assets/img/success.png')"></v-img>
        <div class="resetPass-modal-title">Password Sussfully Rest.</div>
        <div class="resetPass-modal-text">Please remember your new password and keep it safe.</div>
        <button type="button" class="resetPass-modal-btn">Sign In Now</button>
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
    @import url('../../../assets/css/index.less');

    .resetPass-modal {
        .width(627px, 418px);
        .bg-color(white);
        .flex(center, center, column);
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 4px;
        border: solid 1px #eeeeee;

        &-title {
            .color(blackLight);
            font-size: 21px;
            line-height: 1;
            margin-top: 33px;
            margin-bottom: 22px;
        }

        &-text {
            .color(blackLight);
            font-size: 16px;
            line-height: 1;
            margin-bottom: 47px;
        }

        &-btn {
            .width(175px, 50px);
            .color(white);
            .bg-color(Orange);
            font-size: 18px;
            line-height: 1;
            border: none;
        }
    }
</style>
