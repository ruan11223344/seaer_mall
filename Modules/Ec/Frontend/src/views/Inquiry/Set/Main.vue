<template>
    <div class="Send-main">
        <v-title title="Inquiry Rules"></v-title>
        <section class="set-main">
            <h1>Email notificatiom rules</h1>
            <div>
                <Checkbox v-model="single" class="set-main-checkBox"></Checkbox>
                <span>Send the notification email to me while new inquiry received</span>
            </div>
        </section>
    </div>
</template>

<script>
    import Title from "../components/Title"

    export default {
        data() {
            return {
                single: true
            }
        },
        components: {
            "v-title": Title,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .Send-main {
        .width(945px, 700px);
        .bg-color(white);
        padding: 24px 30px;

        .set-main {
            .flex(center, center, column);
            margin-top: 110px;

            & > h1 {
                .color(blackDark);
                font-size: 20px;
                line-height: 1;
                letter-spacing: 0px;
                margin-bottom: 35px;
            }

            & > div:last-child {
                .set-main-checkBox {
                    margin-right: 13px;
                }

                & > span {
                    .color(blackLight);
                    font-size: 16px;
                    line-height: 1;
                    letter-spacing: 0px;
                }
            }
        }
    }

</style>
