<template>
    <div class="container">
        <v-head-template :img="require('@/assets/img/login/bg3.png')" />
        
        <section class="registered-components">
            <v-img width="99" height="101" :imgSrc="require('@/assets/img/success.png')" />
            <div class="registered-components-good">Congratulations! </div>
            <div class="registered-components-title">Registered Successfully.</div>
            <div  class="registered-components-time">
                <time>{{ num }}s</time> Automatic Jump
            </div>
            <router-link to="/home"  class="registered-components-btn" tag="button">Home Page</router-link>
        </section>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    import HeadTemplate from "../components/Head/index"

    export default {
        data() {
            return {
                num: 5
            }
        },
        mounted() {
            let clear = setInterval(() => {
                this.num--
                if(this.num <= 0) {
                    clearInterval(clear)
                    this.$router.push('/home')
                }
            },1000)
        },
        components: {
            'v-img': Img,
            'v-head-template': HeadTemplate,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

    .registered-components {
        width: 1086px;
        height: 610px;
        background-color: #ffffff;
        border-radius: 4px;
        border: solid 1px #eeeeee;
        margin: 0px auto;
        .flex(center, center, column);

        &-good {
            font-size: 21px;
            line-height: 1;
            color: #666666;
            margin-top: 33px;
            margin-bottom: 22px;
        }

        &-title {
            font-size: 16px;
            line-height: 1;
            color: #666666;
        }

        &-time {
            font-size: 16px;
            color: #999999;
            margin-top: 65px;
            margin-bottom: 15px;

            & > time {
                color: #d72b2b;
            }
        }

        &-btn {
            width: 175px;
            height: 50px;
            background-color: #f0883a;
            font-size: 18px;
            line-height: 37px;
            letter-spacing: 0px;
            color: #ffffff;
            border: none;
        }
    }
</style>
