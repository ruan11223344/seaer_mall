<template>
    <section class="tableSwitch">
        <!-- <div :class="'tableSwitch-text ' + (bool == 0 ? 'tableSwitch-text-active' : '')" @click="bool=0">0</div>
        <div class="tableSwitch-hr"></div>
        <div :class="'tableSwitch-text ' + (bool == 1 ? 'tableSwitch-text-active' : '')" @click="bool=1">1</div> -->
        <div :class="'tableSwitch-text ' + (bool == 0 ? 'tableSwitch-text-active' : '')" @click="bool=0">{{ title }}</div>
        <template v-for="(item, index) in tableSwitch" v-if="tableSwitch">
            <div class="tableSwitch-hr"></div>
            <div :class="'tableSwitch-text ' + (bool == index + 1 ? 'tableSwitch-text-active' : '')" @click="bool = index + 1">{{ item }}</div>
        </template>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                bool: 0,
            }
        },
        props: {
            title: {
                type: String
            },
            tableSwitch: {
                type: Array
            }
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .tableSwitch {
            width: 885px;
            height: 47px;
            background-color: #f5f5f9;
            margin-top: 19px;
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

</style>
