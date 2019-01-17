<template>
    <section class="container">
        <v-head-template :img="require('@/assets/img/login/bg1.png')" />

        <div class="Registered-two">
            <v-img width="110" height="108" :imgSrc="require('@/assets/img/login/chengg.png')" class="Registered-two-success"></v-img>
            <div class="Registered-two-content">
                A confirmation email has been sent your mailbox 
                <router-link to="" tag="a">{{ RegEmail.Email }}</router-link>
            </div>
            <p class="Registered-two-prompt">Please check your email box and continue your registration whin 24 hours.</p>
            <a :href="RegEmail.redirect_to" target="view_window"><button type="button" class="Registered-two-btn">Go Check Email</button></a>
        </div>
    </section>
</template>

<script>
    import Img from "@/components/Img"
    import HeadTemplate from "../components/Head/index"
    import { mapState, mapMutations } from 'vuex'

    export default {
        computed: {
            ...mapState([ 'RegEmail' ])
        },
        components: {
            'v-img': Img,
            'v-head-template': HeadTemplate
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

    .Registered-two {
        .width(1086px, 610px);
        background-color: #ffffff;
        border-radius: 4px;
        border: solid 1px #eeeeee;
        margin: 0px auto;

        .flex(center, center, column);

        &-success {
            margin-bottom: 63px;
        }

        &-content {
            font-size: 21px;
            line-height: 1;
            color: #666666;
            margin-bottom: 22px;

            & > a {
                line-height: 1px;
                color: #f0883a;
            }
        }

        &-prompt {
            font-size: 16px;
            line-height: 1;
            color: #999999;
            margin-bottom: 59px;
        }

        &-btn {
            border: none;
            width: 198px;
            height: 50px;
            background-color: #f0883a;
            font-size: 18px;
            line-height: 1;
            color: #ffffff;
        }
    }
</style>
