<template>
    <div class="shade">
        <div class="resetPass-modal">
            <v-img width="99" height="101" :imgSrc="require('@/assets/img/login/chengg.png')"></v-img>
            <div class="resetPass-modal-title">
                We have sent an email to
                <mark class="resetPass-modal-title-mark">wjcharles@163.com</mark>
            </div>
            <div class="resetPass-modal-text">Follow the instructions in the email to reset your passwod.</div>
            <p class="resetPass-modal-content">
                  The email may take up to a few minutes to arrive.If you don't receive,
please check your spam folder or <router-link to="" class="resetPass-modal-content-mark">request another email.</router-link>
            </p>
            <button type="button" class="resetPass-modal-btn">Sign In Now</button>
        </div>
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

    .shade {
        position: fixed;
        top: 0px;
        left: 0px;
        z-index: 10000;
        width: 100%;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.15);
    }

    .resetPass-modal {
        .width(797px, 496px);
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

            &-mark {
                font-weight: normal;
                font-stretch: normal;
                font-style: normal;
                line-height: 11.2px;
                letter-spacing: 0px;
                color: #f0883a;
                background: none;
            }
        }

        &-text {
            .color(gray);
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            line-height: 1;
            margin-bottom: 37px;
        }

        &-content {
            .color(gray);
            width: 490px;
            font-size: 16px;
            line-height: 1.5;
            text-align: center;
            margin-bottom: 32px;

            &-mark {
                text-decoration: underline;
                font-weight: normal;
                letter-spacing: 0px;
                color: #f0883a;
            }
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
