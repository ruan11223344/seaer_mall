<template>
    <h3>{{ title }} <span> {{ subtitle }}</span></h3>
</template>

<script>
    export default {
        props: {
            title: {
                required: true
            },
            subtitle: ''
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    h3 {
        .color(blackLight);
        font-size: 18px;
        line-height: 1;
        padding-bottom: 10px;
        border-bottom: 1px solid #eeeeee;

        & > span {
            font-size: 12px;
            color: #999999;
        }
    }
</style>
