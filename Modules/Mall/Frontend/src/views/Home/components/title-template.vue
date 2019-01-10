<template>
    <div class="title">
        <div class="first">{{ leftTitle }}</div>
        <router-link tag="div" :to="'/goods/list?name=' + leftTitle" class="last" v-if="rightTitle">
            More
            <Icon type="ios-arrow-forward" size="18" color="#999999" class="title-icon"/>
        </router-link>
    </div>
</template>

<script>
    export default {
        props: {
            leftTitle: {
                type: String,
                required: true
            },
            rightTitle: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style lang="less" scoped>
    @import url("../../../assets/css/index.less");

    .title {
        .flex(space-between);

        & > .first {
            .color(blackDark);
            font-size: 20px;
        }

        & > .last {
            .color(gray);
            font-size: 18px;
            cursor: pointer;
        }

        &-icon {
            position: relative;
            top: -1px;
            text-align: right;
        }
    }
</style>
