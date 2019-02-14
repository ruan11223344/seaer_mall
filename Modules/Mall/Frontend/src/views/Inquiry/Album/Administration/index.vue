<template>
    <div class="administration">
        <v-title title="Manage Photos"></v-title>

        <section class="administration-screening">
            <div class="administration-screening-text administration-screening-text-active">My Album</div>

            <!-- <div :class="'Send-main-screening-text ' + (bool == 0 ? 'Send-main-screening-text-active' : '')" @click="bool=0, filterAll(inboxData)">Inbox <span>{{ inboxData.length }}</span></div>
            <div class="Send-main-screening-hr"></div>
            <div :class="'Send-main-screening-text ' + (bool == 1 ? 'Send-main-screening-text-active' : '')" @click="bool=1, filterAll(outboxData)">Sent <span>{{ outboxData.length }}</span></div> -->
        </section>

        <div>
            <button type="button" class="administration-btn" style="marginRight: 10px;">Upload Picture</button>
            <button type="button" class="administration-btn">Create Album</button>
        </div>

        <template>
            <div class="administration-main">
                <v-card-template  v-for="(item, index) in 8" :key="index" class="administration-main-card"></v-card-template>
            </div>
        </template>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    import Title from "../../components/Title"
    import CardTemplateVue from '../components/Card-template.vue';
    


    export default {
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-card-template": CardTemplateVue
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .administration {
        .width(945px, auto);
        min-height: 772px;
        .bg-color(white);
        padding: 21px 30px;

        &-screening {
            .width(886px, 47px);
            background-color: #f5f5f9;
            margin: 20px 0px;
            .flex(flex-start, center);
            padding-left: 27px;

            &-text {
                .lineHeight(47px);
                font-size: 14px;
                color: #666666;

                & > span {
                    color: #d72b2b;
                }
                cursor: pointer;
            }
            &-text-active {
                border-bottom: 2px solid #f0883a;
            }

            &-hr {
                width: 1px;
                height: 11px;
                background-color: #cccccc;
                margin: 0px 18px;
            }
        }

        &-btn {
            width: 105px;
            height: 25px;
            background-color: #f0883a;
            font-size: 14px;
            color: #ffffff;
            border: none;
        }

        &-main {
            margin-top: 20px;

            &-card {
                margin-bottom: 20px;
                margin-right: (885px - (4 * 211px)) / 3;
            }

            &-card:nth-child(4n) {
                margin-right: 0px;
            }
        }
    }
</style>