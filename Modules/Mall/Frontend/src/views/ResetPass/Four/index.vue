<template>
    <div class="resetPass">
        <main class="resetPass-main">
            <div class="box">
                <div class="box-headImg">
                    <v-img width="129" height="131" :imgSrc="require('@/assets/img/success.png')"></v-img>
                </div>
                <div class="box-headTitle">Password successfully reset.</div>
                <div class="box-headLink">
                    <span>Please remember your new password and keep it safe.</span>
                    <router-link to="" tag="a">Sign In Now .</router-link>
                </div>
            </div>
        </main> 
    </div>
</template>

<script>
    import Img from '@/components/Img'

    export default {
        name: 'app',
        data() {
            return {
            }
        },
        methods: {
        },
        mounted() {
        },
        components: {
            'v-img': Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');
    
    .resetPass {
        &-main {
            height: e("calc(100vh - 188px)");
            background-color: #f0f1f5;

            .box {
                .width(770px,492px);
                .flex(felx-start, center, column);
                padding-left: 52px;
                padding-right: 52px;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -51.6%);
                position: relative;


                &-headImg {
                    .width(129px, 131px);
                    border-radius: 50%;
                    overflow: hidden;
                    margin-top: 105px;
                }

                &-headTitle {
                    .width(372px, 27px);
                    .color(blackLight);
                    font-size: 28px;
                    line-height: 1;
                    margin-top: 52px;
                }

                &-headLink {
                    margin-top: 22px;

                    & > span {
                        .color(gray);
                        font-size: 18px;
                        letter-spacing: 0px;
                    }

                    & > span + a {
                        .color(blackLight);
                        font-size: 18px;
                        text-decoration: underline;
                        padding-left: 5px;
                    }
                    & > span + a:hover {
                        .color(Orange);
                    }
                }
                
            }
            .box, .box::after, .box::before {
                content: '';
                .bg-color(white);
                position: absolute;
            }
            .box::after {
                .width(745px, 12px);
                opacity: 0.48;
                left: (770px - 745px) / 2;
                bottom: -12px;
            }
            .box::before {
                .width(726px, 9px);
                opacity: 0.39;
                left: (770px - 726px) / 2;
                bottom: -21px;
            }
        }
    }
        
</style>
