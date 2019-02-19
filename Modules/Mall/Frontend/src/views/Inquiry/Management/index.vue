<template>
    <div class="Management">
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .Management {
        .width(945px, auto);
        min-height: 772px;
        .bg-color(white);
        padding: 21px 30px;
    }
</style>
