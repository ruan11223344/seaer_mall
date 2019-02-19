<template>
    <div class="breadcrumb">
        <template>
            <div class="breadcrumb-text">{{ title }}</div>
        </template>
        <template v-for="item in Breadcrumbs">
            <div class="breadcrumb-text">&nbsp;>&nbsp;</div>
            <div class="breadcrumb-text">{{ item }}</div>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            title: '',
            Breadcrumbs: {
                type: Array
            }
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .breadcrumb {
        .flex();

        & > .breadcrumb-text {
            font-size: 14px;
            color: #666666;
        }
    }
</style>