<template>
    <div class="personal">
        <main class="personal-main">
            <div class="personal-main-left">
                <div class="personal-main-left-head">
                    <img src="" alt="">
                    <dl>
                        <dt class="personal-main-left-head-title">CHENG-NANCY</dt>
                        <dd>(Member ID：wjcharles)</dd>
                        <dt class="personal-main-left-head-free">Free Member</dt>
                        <dd>Membership</dd>
                    </dl>
                </div>

                <div class="personal-main-left-sent">

                </div>

                <div class="personal-main-left-stone">

                </div>
            </div>
            <div class="personal-main-right"></div>
        </main>
    </div>
</template>

<script>
    import getData from "@/utils/getData.js"

    export default {
        data() {
            return {
            }
        },
        methods: {
            
        },
        mounted() {
            
        },
        components: {
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .personal {
        align-self: flex-start;
        width: 944px;
        height: 772px;
        // background-color: #ffffff;
        // padding: 21px 30px;

        &-main {
            .flex(space-betwenn, flex-start);

            &-left {
                width: 657px;

                &-head {
                    width: 657px;
                    height: 180px;
                    background-color: #ffffff;
                    border: solid 1px #eeeeee;
                    .flex(flex-start, center);

                    & > img {
                        width: 122px;
                        height: 122px;
                        background-color: #eeeeee;
                        display: block;
                        border-radius: 50%;
                        margin-left: 22px;
                        margin-right: 30px;
                    }

                    &-title {
                        font-size: 20px;
                        color: #333333;
                        margin-bottom: 12px;
                    }

                    &-title + dd {
                        margin-bottom: 22px;
                    }

                    &-free {
                        font-size: 16px;
                        color: #666666;
                        margin-bottom: 10px;
                    }

                    &-title + dd, &-free + dd {
                        font-size: 14px;
                        color: #999999;
                    }

                    &-title, &-title + dd, &-free, &-free + dd {
                        line-height: 1;
                    }
                }

                &-sent {
                    width: 657px;
                    height: 121px;
                    background-color: #ffffff;
                    border: solid 1px #eeeeee;
                    margin-top: 10px;
                }

                &-stone {
                    width: 657px;
                    height: 234px;
                    background-color: #ffffff;
                    border: solid 1px #eeeeee;
                    margin-top: 10px;
                }
            }

            &-right {
                width: 279px;

            }
        }
    }
</style>
