<template>
    <h3>{{ title }}</h3>
</template>

<script>
    export default {
        props: {
            title: {
                required: true
            }
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
    }
</style>
