<template>
    <div class="resetPass">
        <main class="resetPass-main">
            <div class="box">
                <div class="box-headImg">
                    <v-img width="129" height="131" :imgSrc="require('@/assets/img/success.png')"></v-img>
                </div>
                <div class="box-headTitle">
                    <p>We have sent an email to <strong>{{ '"5214521545@qq.com"' }}</strong></p>
                    <p>Follow the instructions in the Email to reset your password.</p>
                </div>
                <div class="box-headLink">
                    <p>The Email may take up to a few minutes to arrive.</p>
                    <p>If you don't receive,Please check your spam folder or<router-link to="" tag="a"> request another email .</router-link></p>
                    
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
                .width(770px,429px);
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
                    margin-top: 72px;
                    margin-bottom: 42px;
                }

                &-headTitle {
                    & > p:first-child {
                        .color(blackLight);
                        font-size: 20px;
                        line-height: 1;
                        text-align: center;
                        & > strong {
                            .color(success);
                            font-weight: normal;
                        }
                    }

                    & > p:last-child {
                        margin-top: 5px;
                        .color(blackLight);
                        font-size: 20px;
                        line-height: 1;
                        text-align: center;
                    }
                }

                &-headLink {
                    margin-top: 25px;
                    text-align: center;
                    line-height: 1;
                    font-size: 16px;

                    & > p {
                        .color(gray);
                    }

                    & > p:last-child {
                        margin-top: 5px;

                        & > a {
                            text-decoration: underline;
                            .color(blackLight);
                        }

                        & > a:hover {
                            .color(Orange);
                        }
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
