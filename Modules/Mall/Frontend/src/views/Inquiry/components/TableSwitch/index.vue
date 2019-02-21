<template>
    <section class="tableSwitch">
        <div :class="'tableSwitch-text ' + (num == 0 ? 'tableSwitch-text-active' : '')" @click="onSwitch(0)">{{ title }}</div>
        <template v-for="(item, index) in tableSwitch" v-if="tableSwitch">
            <div class="tableSwitch-hr"></div>
            <div :class="'tableSwitch-text ' + (num == index + 1 ? 'tableSwitch-text-active' : '')" @click="onSwitch(index + 1)">{{ item }}</div>
        </template>
    </section>
</template>

<script>
    export default {
        data() {
            return {
            }
        },
        props: {
            num: {
                type: Number,
                default: 0
            },
            title: {
                type: String
            },
            tableSwitch: {
                type: Array
            }
        },
        methods: {
            onSwitch(num) {
                this.$emit('on-click', num)
            },
        },
        watch: {
            
        },
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
